<?php
/*
 * DATABASE PLACEHOLDER — deliberately inactive during the structure stage.
 *
 * Later this file will:
 * 1. Detect localhost versus Coreteaching.
 * 2. Load the appropriate connection settings safely.
 * 3. Connect with procedural mysqli_connect().
 * 4. Set utf8mb4 using mysqli_set_charset().
 * 5. Provide development diagnostics without exposing credentials in production.
 *
 * Local database: bookverse
 * Jacob 5 database: s4178376
 * Confirm the actual Jacob 5 hostname and credentials from RMIT instructions.
 * Do not commit passwords or invent connection settings.
 *
 * Every future query must use procedural MySQLi prepared statements.
 * Pages do not require this file yet, so no database connection is attempted.
 */
$connection = null;

