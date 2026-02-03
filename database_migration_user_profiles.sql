-- Tabel untuk menyimpan data profile customer
CREATE TABLE IF NOT EXISTS user_profiles (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id     INT NOT NULL UNIQUE,
    
    -- Data Pribadi
    phone       VARCHAR(20) NULL,
    birth_place VARCHAR(100) NULL,
    birth_date  DATE NULL,
    gender      ENUM('male','female','other') NULL,
    
    -- Alamat
    address     TEXT NULL,
    city        VARCHAR(100) NULL,
    province    VARCHAR(100) NULL,
    postal_code VARCHAR(10) NULL,
    country     VARCHAR(100) NULL DEFAULT 'Indonesia',
    
    -- Timestamps
    created_at  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
