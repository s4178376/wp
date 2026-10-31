

## adding the commonly used code for me as I keep coming back to it

```bash
sudo /Applications/XAMPP/xamppfiles/xampp start
sudo /Applications/XAMPP/xamppfiles/xampp status
```

Apache and MySQL must be running. Open http://localhost/phpmyadmin/.

## setting up local databases
## I keep forgetting
If `bookverse_a3` is not already populated, import `a3/database/local_setup.sql` once through phpMyAdmin. It creates the A3 tables and sample records separately from A2.

Do not reimport a populated database. Do not substitute `database/bookverse.sql`: the supplied original contains DROP statements targeting its selected database.

Default local connection settings in the starter:

| Setting | Value |
| --- | --- |
| Host | 127.0.0.1 |
| Port | 3306 |
| User | root |
| Password | Empty unless you changed it |
| Database | bookverse_a3 |

If your local credentials differ, copy `includes/config.example.php` to `includes/config.private.php` only if the private file does not already exist. Change its `local` settings privately. Never overwrite existing private credentials with the example.

## 4. Open and check

Open http://localhost/wp/a3/.

The supplied sample login is `john_reader` with password `password123`. These are sample development credentials from the course SQL.

Check the homepage, catalogue, gallery, details, search and seller links. Test login/logout and confirm owner controls appear only for books owned by that account.

Registration now creates a user and automatically logs them in. Test it locally with a new username/email. Add/edit/delete processing still stops with an explanatory message and does not change book records or upload images.

PHP syntax check from your Mac:

```bash
cd /Applications/XAMPP/xamppfiles/htdocs/wp/a3
find . -type f \( -name '*.php' -o -name '*.inc' \) \
  -exec /Applications/XAMPP/xamppfiles/bin/php -l {} \;
```

Record the actual results, not an assumed pass.

## 5. Suggested development order

1. Test registration: create an account, log out/in, try duplicate details and mismatched passwords, and confirm the database stores a hash.
2. Implement Add Book validation, verified uploads and owner-linked insertion.
3. Implement owner-only editing, keeping the existing cover unless replaced.
4. Implement owner-only deletion and safe image cleanup.
5. Test two accounts, invalid requests, flash feedback, layouts and validators.
6. Confirm the A3 live database plan, deploy and test on Titan/Jacob 5.

Update your README and process evidence progressively. The written brief requires five debugging records, five meaningful AI-use records, and genuine linked Git history.

## Live setup comes separately

The A3 private `live` settings are blank. Confirm the assigned database and how to preserve A2 data before importing anything into Jacob 5. Do not run the supplied destructive SQL over the working A2 tables.

When uploads are implemented, configure cover-directory permissions according to the course brief and test them under Apache. The local XAMPP database does not automatically sync to Jacob 5.
