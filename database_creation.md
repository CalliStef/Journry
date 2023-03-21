# Database creation script

```php
$user_sql = "CREATE TABLE IF NOT EXISTS user (
        id INT NOT NULL AUTO_INCREMENT,
        username VARCHAR(50) NOT NULL UNIQUE,
        password VARCHAR(50) NOT NULL,
        PRIMARY KEY (id)
        );";

$journal_sql = "CREATE TABLE IF NOT EXISTS journal (
    id INT NOT NULL AUTO_INCREMENT,
    content VARCHAR(500) NOT NULL,
    created_date DATE NOT NULL,
    user_id INT NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (user_id) REFERENCES user(id)
);";

$image_sql = "CREATE TABLE IF NOT EXISTS image (
    id INT NOT NULL AUTO_INCREMENT,
    filename VARCHAR(255) NOT NULL,
    journal_id INT NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (journal_id) REFERENCES journal(id)
);";

```
