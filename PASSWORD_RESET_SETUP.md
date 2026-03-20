# Configuration du mot de passe oublié

Pour que l'envoi d'emails de réinitialisation fonctionne, suivez ces étapes :

## 1. Installer PHPMailer (Composer)

À la racine du projet, exécutez :

```bash
composer install
```

Si Composer n'est pas installé : [https://getcomposer.org/download/](https://getcomposer.org/download/)

## 2. Configurer Gmail

1. **Activez la double authentification** sur votre compte Google
2. Allez sur : [https://myaccount.google.com/apppasswords](https://myaccount.google.com/apppasswords)
3. Créez un **mot de passe d'application** pour "Mail"
4. Copiez le mot de passe de 16 caractères généré

## 3. Modifier la configuration

Éditez le fichier `config/mail_config.php` et remplacez :

- `your-email@gmail.com` par votre adresse Gmail
- `your-16-char-app-password` par le mot de passe d'application généré

## Utilisation

1. Sur la page de connexion, cliquez sur **"Oublié ?"**
2. Entrez votre adresse email
3. Cliquez sur **"Envoyer le lien"**
4. Vérifiez votre boîte mail et cliquez sur le lien reçu
5. Définissez votre nouveau mot de passe
