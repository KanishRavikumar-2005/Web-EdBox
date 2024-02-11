# Web EdBox

[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)
[![GitHub contributors](https://img.shields.io/github/contributors/kanishravikumar-2005/Web-EdBox.svg)](https://github.com/kanishravikumar-2005/Web-EdBox/graphs/contributors)
![Pull Requests](https://img.shields.io/github/issues-pr/kanishravikumar-2005/Web-EdBox) [![GitHub code size in bytes](https://img.shields.io/github/languages/code-size/kanishravikumar-2005/Web-EdBox.svg)](https://github.com/kanishravikumar-2005/Web-EdBox) [![GitHub last commit](https://img.shields.io/github/last-commit/kanishravikumar-2005/Web-EdBox.svg)](https://github.com/kanishravikumar-2005/Web-EdBox/commits/master)
![GitHub release (latest by date)](https://img.shields.io/github/v/release/kanishravikumar-2005/Web-EdBox?include_prereleases)

[![GitHub stars](https://img.shields.io/github/stars/kanishravikumar-2005/Web-EdBox.svg)](https://github.com/kanishravikumar-2005/Web-EdBox/stargazers)[![GitHub forks](https://img.shields.io/github/forks/kanishravikumar-2005/Web-EdBox.svg)](https://github.com/kanishravikumar-2005/Web-EdBox/network)

Web EdBox is an open-source project editor IDE built entirely in PHP. It provides a secure environment for managing and editing project code on a server without granting full server access. With Web EdBox, managers can create and manage developers and admins, while developers have access to edit the code of the project.

## Features

- **User Access Control**: Managers have full control over user access, while developers have limited access to project code.
- **Secure Environment**: File and folder access control prevents accidental modifications of critical files.
- **Backup System**: Automatically backs up previous versions of edited files to the developers local system for easy recovery in case of errors.

## Setup

1. Fill in the required credentials (Encryption IV Key, EKey) in `editor/login/dataEnc.php`.
2. Default cipher method used is `AES-256-CBC`, but this can be modified.
3. Upload the Web EdBox folder to your server.
4. Open the editor using the URL `http://[siteurl]/editor`.
5. Upon setup completion, the editor will ask for a manager username and password for setup [This step must be performed immediately after setup].

## Vulnerabilities

- **ALLNEW Vulnerability**: Opening the editor without populating the user database will expose the user access page, allowing the creation of a manager.

**Solution:** To prevent this vulnerability, simply create the manager user as soon as setting up the editor, if you want to remove manager without having access to the editor, you can clear out the dbase.jdb file contents from within the server which will make the editor allow creating a new manager.

## Usage

- The editor hides certain files and folders (`editHide`) and makes others inaccessible (`editLocked`) to prevent accidental modifications.
- File names can also be used to lock (`*.elock.*`) and hide (`*.ehide.*`) induvidual files.
- Developers can edit files and must press "Save to Site" to save changes. Previous versions are automatically backed up in the developers’ local computer for recovery, as a `.txt` file.<br>

**Note:** Intentional modifications using code can be performed on locked files and folders as usual, locking and hiding is to just prevent accedental modifications.

## Directory Structure
```
Server Root:.
└── editor
    | ├── index.php
    | └── style.css
    |
    └── images
    |    ├── edicon.png
    |    └── edlogo.png
    |
    └── login
    |    ├── data.php
    |    ├── dataEnc.php
    |    ├── dbase.jdb
    |    └── index.php
    |
    └── master
         └── index.php
```

## Note

Changing filenames or codes without proper understanding may lead to errors. Ensure to follow the setup instructions carefully to avoid vulnerabilities.

## License

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.
