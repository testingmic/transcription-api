<?php
global $databases, $alterTables;

use CodeIgniter\Database\Exceptions\DatabaseException;

// Create the databases
$databases = [

    "CREATE TABLE IF NOT EXISTS users (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        username VARCHAR(100) UNIQUE NOT NULL,
        email VARCHAR(150) UNIQUE NOT NULL,
        phone VARCHAR(20) DEFAULT NULL,
        password VARCHAR(255) NOT NULL,
        name VARCHAR(150) NOT NULL,
        role VARCHAR(50) NOT NULL DEFAULT 'User', -- 'User', 'Admin', 'Moderator'
        status VARCHAR(20) DEFAULT 'Active', -- 'Active', 'Inactive', 'Suspended'
        two_factor_setup INTEGER DEFAULT 0,
        last_login DATETIME DEFAULT NULL,
        twofactor_secret TEXT DEFAULT NULL,
        image VARCHAR(255),
        pin_hash TEXT DEFAULT NULL,
        nationality VARCHAR(100),
        gender VARCHAR(20) DEFAULT NULL,
        date_of_birth DATE DEFAULT NULL,
        timezone VARCHAR(50) DEFAULT 'Africa/Accra',
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
    );
    CREATE INDEX IF NOT EXISTS idx_users_email ON users(email);
    CREATE INDEX IF NOT EXISTS idx_users_role ON users(role);
    CREATE INDEX IF NOT EXISTS idx_users_status ON users(status);",

    "CREATE TABLE IF NOT EXISTS funnel_events_map (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        event_name VARCHAR(100) NOT NULL,
        driver_id INTEGER DEFAULT 0,
        pickup_id INTEGER DEFAULT 0,
        contractor_id INTEGER DEFAULT 0,
        household_id INTEGER DEFAULT 0,
        event_date DATE NOT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
    );
    CREATE INDEX IF NOT EXISTS idx_funnel_events_map_event_name ON funnel_events_map(event_name);
    CREATE INDEX IF NOT EXISTS idx_funnel_events_map_driver_id ON funnel_events_map(driver_id);
    CREATE INDEX IF NOT EXISTS idx_funnel_events_map_pickup_id ON funnel_events_map(pickup_id);
    CREATE INDEX IF NOT EXISTS idx_funnel_events_map_contractor_id ON funnel_events_map(contractor_id);
    CREATE INDEX IF NOT EXISTS idx_funnel_events_map_household_id ON funnel_events_map(household_id);
    CREATE INDEX IF NOT EXISTS idx_funnel_events_map_event_date ON funnel_events_map(event_date);",

    "CREATE TABLE IF NOT EXISTS user_token_auth (
        idusertokenauth INTEGER PRIMARY KEY AUTOINCREMENT,
        username TEXT,
        description TEXT,
        password TEXT UNIQUE,
        hash_algo TEXT,
        system_token INTEGER NOT NULL DEFAULT 0,
        last_used DATETIME DEFAULT NULL,
        date_created DATETIME DEFAULT CURRENT_TIMESTAMP,
        date_expired DATETIME DEFAULT NULL,
        ipaddress TEXT DEFAULT NULL
    );
    CREATE INDEX IF NOT EXISTS idx_user_token_auth_username ON user_token_auth (username);
    CREATE INDEX IF NOT EXISTS idx_user_token_auth_password ON user_token_auth (password);
    CREATE INDEX IF NOT EXISTS idx_user_token_auth_last_used ON user_token_auth (last_used);
    CREATE INDEX IF NOT EXISTS idx_user_token_auth_date_created ON user_token_auth (date_created);
    CREATE INDEX IF NOT EXISTS idx_user_token_auth_date_expired ON user_token_auth (date_expired);
    CREATE INDEX IF NOT EXISTS idx_user_token_auth_ipaddress ON user_token_auth (ipaddress);",

    "CREATE TABLE IF NOT EXISTS altuser (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        user_id TEXT,
        ver_code INTEGER,
        username TEXT,
        full_name TEXT,
        email TEXT,
        auth TEXT,
        time_added DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        request TEXT DEFAULT 'register',
        is_test INTEGER NOT NULL DEFAULT 0
    );
    CREATE INDEX IF NOT EXISTS idx_altuser_user_id ON altuser (user_id);
    CREATE INDEX IF NOT EXISTS idx_altuser_ver_code ON altuser (ver_code);
    CREATE INDEX IF NOT EXISTS idx_altuser_username ON altuser (username);
    CREATE INDEX IF NOT EXISTS idx_altuser_email ON altuser (email);",

    "CREATE TABLE IF NOT EXISTS transcriptions (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        user_id INTEGER NOT NULL,
        title VARCHAR(100) NOT NULL,
        transcription TEXT NOT NULL,
        summary TEXT DEFAULT NULL,
        keywords TEXT DEFAULT NULL,
        language VARCHAR(50) DEFAULT 'en',
        tags TEXT DEFAULT NULL,
        duration INTEGER DEFAULT 0,
        fileSize INTEGER DEFAULT 0,
        metadata TEXT DEFAULT NULL,
        status VARCHAR(20) DEFAULT 'Pending',
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
    );
    CREATE INDEX IF NOT EXISTS idx_transcriptions_user_id ON transcriptions (user_id);
    CREATE INDEX IF NOT EXISTS idx_transcriptions_title ON transcriptions (title);
    CREATE INDEX IF NOT EXISTS idx_transcriptions_status ON transcriptions (status);",

    "CREATE TABLE IF NOT EXISTS audio_files (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        transcription_id INTEGER NOT NULL,
        user_id INTEGER NOT NULL,
        audioUrl TEXT DEFAULT NULL,
        thumbnails TEXT DEFAULT NULL,
        mimeType VARCHAR(100) NOT NULL,
        size INTEGER NOT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
    );
    CREATE INDEX IF NOT EXISTS idx_audio_files_transcription_id ON audio_files (transcription_id);
    CREATE INDEX IF NOT EXISTS idx_audio_files_mimeType ON audio_files (mimeType);
    CREATE INDEX IF NOT EXISTS idx_audio_files_size ON audio_files (size);",
];

$alterTables = [
    "ALTER TABLE users ADD COLUMN pin_hash TEXT DEFAULT NULL;",
];

function createDatabaseStructure() {
    global $databases, $alterTables;
    $db = \Config\Database::connect();
    // $db->query("drop table organizations");
    foreach(array_merge($alterTables, $databases) as $query) {
        try {
            if(empty($query)) continue;
            $db->query($query);
        } catch(DatabaseException $e) {
        }
    }
}

/**
 * Set the database settings
 * 
 * @param object $dbHandler
 * 
 * @return void
 */
function setDatabaseSettings($dbHandler) {
    $dbHandler->query("PRAGMA journal_mode = WAL");
    $dbHandler->query("PRAGMA synchronous = NORMAL");
    $dbHandler->query("PRAGMA locking_mode = NORMAL");
    $dbHandler->query("PRAGMA busy_timeout = 5000");
    $dbHandler->query("PRAGMA cache_size = -16000");
}
