/* ------------------------------
   GLOBAL RESET
--------------------------------*/
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: Arial, sans-serif;
    background: #f5f5f5;
    color: #333;
    line-height: 1.6;
}

/* ------------------------------
   LAYOUT
--------------------------------*/
.container {
    width: 90%;
    max-width: 1100px;
    margin: 20px auto;
}

/* ------------------------------
   NAVIGATION
--------------------------------*/
nav {
    background: #004aad;
    padding: 15px 0;
}

nav .nav-container {
    width: 90%;
    max-width: 1100px;
    margin: auto;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

nav a {
    color: white;
    text-decoration: none;
    margin-left: 20px;
    font-weight: bold;
}

nav a:hover {
    text-decoration: underline;
}

/* ------------------------------
   HEADER
--------------------------------*/
header h1 {
    margin-bottom: 20px;
}

/* ------------------------------
   TABLES
--------------------------------*/
table {
    width: 100%;
    border-collapse: collapse;
    background: white;
    margin-top: 20px;
}

table th, table td {
    padding: 12px;
    border: 1px solid #ddd;
}

table th {
    background: #eee;
    text-align: left;
}

/* ------------------------------
   BUTTONS
--------------------------------*/
button, .btn {
    background: #004aad;
    color: white;
    padding: 8px 14px;
    border: none;
    cursor: pointer;
    text-decoration: none;
    display: inline-block;
    border-radius: 4px;
}

button:hover, .btn:hover {
    background: #00337a;
}

/* Delete button */
.btn-danger {
    background: #c62828;
}

.btn-danger:hover {
    background: #8e1c1c;
}

/* ------------------------------
   ALERTS
--------------------------------*/

.alert {
    padding: 12px 15px;
    margin: 15px 0;
    border-radius: 4px;
}

.alert-success {
    background: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

.alert-error {
    background: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}

/* ------------------------------
   FORMS
--------------------------------*/
form label {
    display: block;
    margin-top: 15px;
    font-weight: bold;
}

form input, form select {
    width: 100%;
    padding: 8px;
    margin-top: 5px;
    border: 1px solid #aaa;
    border-radius: 4px;
}

form .form-row {
    display: flex;
    gap: 20px;
}

form .form-row > div {
    flex: 1;
}

form button {
    margin-top: 20px;
}

/* ------------------------------
   FOOTER
--------------------------------*/
footer {
    margin-top: 40px;
    padding: 20px;
    background: #004aad;
    color: white;
    text-align: center;
}
