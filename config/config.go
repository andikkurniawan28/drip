package config

import (
	"database/sql"
	"fmt"
	"log"
	"os"

	_ "github.com/go-sql-driver/mysql"
	"github.com/joho/godotenv"
)

func ConnectDB() *sql.DB {
	// Load .env
	err := godotenv.Load()
	if err != nil {
		log.Println("⚠️  No .env file found, using system env")
	}

	host := os.Getenv("DB_HOST")
	port := os.Getenv("DB_PORT")
	user := os.Getenv("DB_USER")
	pass := os.Getenv("DB_PASS")
	name := os.Getenv("DB_NAME")

	// Data Source Name (DSN)
	dsn := fmt.Sprintf("%s:%s@tcp(%s:%s)/%s?parseTime=true", user, pass, host, port, name)

	db, err := sql.Open("mysql", dsn)
	if err != nil {
		log.Fatal("❌ Failed to connect database:", err)
	}

	if err = db.Ping(); err != nil {
		log.Fatal("❌ Database unreachable:", err)
	}

	fmt.Println("✅ Database connected")
	return db
}
