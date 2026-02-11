/**
 * admin.js
 * Student management and grade editing logic for the admin dashboard.
 */
let currentStudents = [];
let editingStudentId = null;

async function fetchStudents() {
    try {
        const response = await fetch('../assets/php/admin_api.php', {
            method: 'POST',
            body: JSON.stringify({ action: 'get_students' })
        });
        const result = await response.json();
        if (result.status === 'success') {
            currentStudents = result.students;
            renderStudents(currentStudents);
        } else {
            console.error(result.message);
        }
    } catch (error) {
        console.error('Error fetching students:', error);
    }
}

function renderStudents(students) {
    const tbody = document.getElementById('studentTableBody');
    if (!tbody) return;

    if (students.length === 0) {
        tbody.innerHTML = '<tr><td colspan="6" class="text-center py-4">Aucun stagiaire trouvé</td></tr>';
        return;
    }

    tbody.innerHTML = students.map(s => {
        const avg = calculateAverage(s.grades);
        return `
        <tr>
            <td class="ps-4">
                <div class="d-flex align-items-center">
                    <img src="../assets/php/${s.profile_image || '../assets/images/user_page/default-profile.png'}" 
                         class="rounded-circle me-3" style="width: 40px; height: 40px; object-fit: cover;">
                    <span class="fw-bold">${s.fullname}</span>
                </div>
            </td>
            <td>${s.email}</td>
            <td><span class="badge bg-light text-dark border">${s.filiere || 'N/A'}</span></td>
            <td>${s.year || 'N/A'}</td>
            <td><span class="fw-bold ${avg >= 10 ? 'text-success' : 'text-danger'}">${avg}</span></td>
            <td class="text-end pe-4">
                <button class="btn btn-sm btn-outline-primary" onclick="openGradeModal('${s.id}')">
                    <i class="bi bi-pencil-square me-1"></i> Gérer Notes
                </button>
                ${USER_ROLE === 'CEO' ? `
                <button class="btn btn-sm btn-outline-danger ms-1" onclick="deleteStudent('${s.id}')">
                    <i class="bi bi-trash"></i>
                </button>` : ''}
            </td>
        </tr>
    `;
    }).join('');
}

async function deleteStudent(studentId) {
    if (!confirm('Êtes-vous sûr de vouloir supprimer ce stagiaire définitivement ?')) {
        return;
    }

    try {
        const response = await fetch('../assets/php/admin_api.php', {
            method: 'POST',
            body: JSON.stringify({
                action: 'delete_student',
                student_id: studentId,
                csrf_token: CSRF_TOKEN
            })
        });
        const result = await response.json();

        if (result.status === 'success') {
            await fetchStudents(); // Refresh the list
        } else {
            alert('Erreur: ' + result.message);
        }
    } catch (error) {
        console.error('Error deleting student:', error);
    }
}


function calculateAverage(grades) {
    if (!grades || grades.length === 0) return 'N/A';
    let totalPoints = 0;
    let totalCoeff = 0;
    
    grades.forEach(g => {
        const note = parseFloat(g.note) || 0;
        const coeff = parseFloat(g.coeff) || 1;
        totalPoints += note * coeff;
        totalCoeff += coeff;
    });
    
    return totalCoeff > 0 ? (totalPoints / totalCoeff).toFixed(2) : '0.00';
}

function openGradeModal(studentId) {
    const student = currentStudents.find(s => s.id === studentId);
    editingStudentId = studentId;
    document.getElementById('modalStudentName').textContent = student.fullname;
    renderGrades(student.grades);

    new bootstrap.Modal(document.getElementById('gradeModal')).show();
}

function renderGrades(grades) {
    const list = document.getElementById('gradesList');
    if (!grades || grades.length === 0) {
        list.innerHTML = '<p class="text-center text-muted my-3">Aucune note enregistrée</p>';
        return;
    }

    list.innerHTML = grades.map((g, index) => `
    <div class="row g-2 mb-2 p-2 border rounded align-items-center">
        <div class="col-md-6">
            <input type="text" class="form-control form-control-sm grade-module" value="${g.module}" placeholder="Module">
        </div>
        <div class="col-md-2">
            <input type="number" class="form-control form-control-sm grade-note" value="${g.note}" step="0.25" min="0" max="20" placeholder="Note">
        </div>
        <div class="col-md-2">
            <input type="number" class="form-control form-control-sm grade-coeff" value="${g.coeff || 1}" step="0.5" min="1" placeholder="Coeff">
        </div>
        <div class="col-md-2 text-end">
            <button class="btn btn-sm btn-outline-danger" onclick="this.parentElement.parentElement.remove()">
                <i class="bi bi-trash"></i>
            </button>
        </div>
    </div>
`).join('');
}

function addNewGrade() {
    const moduleInput = document.getElementById('newModule');
    const noteInput = document.getElementById('newNote');
    const coeffInput = document.getElementById('newCoeff');
    
    const module = moduleInput.value.trim();
    const note = noteInput.value;
    const coeff = coeffInput ? coeffInput.value : 1;

    if (!module || note === '') return;

    const list = document.getElementById('gradesList');
    if (list.querySelector('.text-muted')) list.innerHTML = '';

    const row = document.createElement('div');
    row.className = 'row g-2 mb-2 p-2 border rounded align-items-center';
    row.innerHTML = `
    <div class="col-md-6">
        <input type="text" class="form-control form-control-sm grade-module" value="${module}">
    </div>
    <div class="col-md-2">
        <input type="number" class="form-control form-control-sm grade-note" value="${note}" step="0.25" min="0" max="20">
    </div>
    <div class="col-md-2">
        <input type="number" class="form-control form-control-sm grade-coeff" value="${coeff}" step="0.5" min="1">
    </div>
    <div class="col-md-2 text-end">
        <button class="btn btn-sm btn-outline-danger" onclick="this.parentElement.parentElement.remove()">
            <i class="bi bi-trash"></i>
        </button>
    </div>
`;
    list.appendChild(row);

    moduleInput.value = '';
    noteInput.value = '';
    if (coeffInput) coeffInput.value = 1;
}

document.addEventListener('DOMContentLoaded', () => {
    const saveGradesBtn = document.getElementById('saveGradesBtn');
    if (saveGradesBtn) {
        saveGradesBtn.addEventListener('click', async () => {
            const modules = document.querySelectorAll('.grade-module');
            const notes = document.querySelectorAll('.grade-note');
            const coeffs = document.querySelectorAll('.grade-coeff');

            const updatedGrades = [];
            for (let i = 0; i < modules.length; i++) {
                updatedGrades.push({
                    module: modules[i].value.trim(),
                    note: notes[i].value,
                    coeff: coeffs[i] ? coeffs[i].value : 1
                });
            }


            saveGradesBtn.disabled = true;
            saveGradesBtn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Enregistrement...';

            try {
                const response = await fetch('../assets/php/admin_api.php', {
                    method: 'POST',
                    body: JSON.stringify({
                        action: 'update_grades',
                        student_id: editingStudentId,
                        grades: updatedGrades,
                        csrf_token: CSRF_TOKEN
                    })
                });
                const result = await response.json();

                if (result.status === 'success') {
                    await fetchStudents(); // Refresh data
                    bootstrap.Modal.getInstance(document.getElementById('gradeModal')).hide();
                } else {
                    alert('Erreur: ' + result.message);
                }
            } catch (error) {
                console.error('Error saving grades:', error);
            } finally {
                saveGradesBtn.disabled = false;
                saveGradesBtn.textContent = 'Enregistrer les Modifications';
            }
        });
    }

    const studentSearchInput = document.getElementById('studentSearch');
    if (studentSearchInput) {
        studentSearchInput.addEventListener('input', (e) => {
            const term = e.target.value.toLowerCase();
            const filtered = currentStudents.filter(s =>
                s.fullname.toLowerCase().includes(term) ||
                s.email.toLowerCase().includes(term)
            );
            renderStudents(filtered);
        });
    }

    // Initial fetch
    if (document.getElementById('studentTableBody')) {
        fetchStudents();
    }

    if (USER_ROLE === 'CEO' && document.getElementById('adminTableBody')) {
        fetchAdmins();
    }
});

/** CEO Management Functions **/

async function fetchAdmins() {
    try {
        const response = await fetch('../assets/php/admin_api.php', {
            method: 'POST',
            body: JSON.stringify({ action: 'get_admins' })
        });
        const result = await response.json();
        if (result.status === 'success') {
            renderAdminsTable(result.admins);
        }
    } catch (error) {
        console.error('Error fetching admins:', error);
    }
}

function renderAdminsTable(admins) {
    const tbody = document.getElementById('adminTableBody');
    if (!tbody) return;

    tbody.innerHTML = admins.map(a => `
        <tr>
            <td>${a.fullname}</td>
            <td>${a.email}</td>
            <td><span class="badge ${a.role === 'CEO' ? 'bg-primary' : 'bg-secondary'}">${a.role}</span></td>
            <td class="text-end">
                ${a.role !== 'CEO' ? `
                <button class="btn btn-sm btn-link text-danger" onclick="deleteAdmin('${a.id}')">
                    <i class="bi bi-person-x"></i> Supprimer
                </button>` : '<span class="text-muted small">Propriétaire</span>'}
            </td>
        </tr>
    `).join('');
}

function openAddAdminModal() {
    new bootstrap.Modal(document.getElementById('adminModal')).show();
}

async function submitAddAdmin() {
    const fullname = document.getElementById('adminFullname').value;
    const email = document.getElementById('adminEmail').value;
    const password = document.getElementById('adminPassword').value;

    if (!fullname || !email || !password) return alert('Tous les champs sont requis');

    try {
        const response = await fetch('../assets/php/admin_api.php', {
            method: 'POST',
            body: JSON.stringify({
                action: 'add_admin',
                fullname: fullname,
                email: email,
                password: password,
                csrf_token: CSRF_TOKEN
            })
        });
        const result = await response.json();
        if (result.status === 'success') {
            bootstrap.Modal.getInstance(document.getElementById('adminModal')).hide();
            fetchAdmins();
            document.getElementById('addAdminForm').reset();
        } else {
            alert(result.message);
        }
    } catch (error) {
        console.error('Error adding admin:', error);
    }
}

async function deleteAdmin(adminId) {
    if (!confirm('Voulez-vous vraiment supprimer cet administrateur ?')) return;

    try {
        const response = await fetch('../assets/php/admin_api.php', {
            method: 'POST',
            body: JSON.stringify({
                action: 'delete_admin',
                admin_id: adminId,
                csrf_token: CSRF_TOKEN
            })
        });
        const result = await response.json();
        if (result.status === 'success') {
            fetchAdmins();
        } else {
            alert(result.message);
        }
    } catch (error) {
        console.error('Error deleting admin:', error);
    }
}
