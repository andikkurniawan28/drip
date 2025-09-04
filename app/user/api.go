package user

import (
	"database/sql"
	"encoding/json"
	"net/http"

	"github.com/gorilla/mux"
)

type User struct {
	ID     int    `json:"id"`
	Name   string `json:"name"`
	Email  string `json:"email"`
	RoleID int    `json:"role_id"`
}

func GetUsers(db *sql.DB) http.HandlerFunc {
	return func(w http.ResponseWriter, r *http.Request) {
		rows, err := db.Query("SELECT id, name, email, role_id FROM user ORDER BY id ASC")
		if err != nil {
			http.Error(w, err.Error(), http.StatusInternalServerError)
			return
		}
		defer rows.Close()

		var users []User
		for rows.Next() {
			var u User
			if err := rows.Scan(&u.ID, &u.Name, &u.Email, &u.RoleID); err != nil {
				http.Error(w, err.Error(), http.StatusInternalServerError)
				return
			}
			users = append(users, u)
		}

		w.Header().Set("Content-Type", "application/json")
		json.NewEncoder(w).Encode(users)
	}
}

// GET by ID
func GetUserByID(db *sql.DB) http.HandlerFunc {
	return func(w http.ResponseWriter, r *http.Request) {
		id := mux.Vars(r)["id"]
		var u User
		err := db.QueryRow("SELECT id, name, email, role_id FROM user WHERE id = ?", id).
			Scan(&u.ID, &u.Name, &u.Email, &u.RoleID)
		if err != nil {
			http.Error(w, err.Error(), http.StatusInternalServerError)
			return
		}
		w.Header().Set("Content-Type", "application/json")
		json.NewEncoder(w).Encode(u)
	}
}

// POST
func CreateUser(db *sql.DB) http.HandlerFunc {
	return func(w http.ResponseWriter, r *http.Request) {
		var u User
		if err := json.NewDecoder(r.Body).Decode(&u); err != nil {
			http.Error(w, err.Error(), http.StatusBadRequest)
			return
		}
		result, err := db.Exec("INSERT INTO user (name, email, role_id) VALUES (?, ?, ?)", u.Name, u.Email, u.RoleID)
		if err != nil {
			http.Error(w, err.Error(), http.StatusInternalServerError)
			return
		}
		lastID, _ := result.LastInsertId()
		u.ID = int(lastID)
		w.Header().Set("Content-Type", "application/json")
		json.NewEncoder(w).Encode(u)
	}
}

// PUT
func UpdateUser(db *sql.DB) http.HandlerFunc {
	return func(w http.ResponseWriter, r *http.Request) {
		id := mux.Vars(r)["id"]
		var u User
		if err := json.NewDecoder(r.Body).Decode(&u); err != nil {
			http.Error(w, err.Error(), http.StatusBadRequest)
			return
		}
		_, err := db.Exec("UPDATE user SET name=?, email=?, role_id=? WHERE id=?", u.Name, u.Email, u.RoleID, id)
		if err != nil {
			http.Error(w, err.Error(), http.StatusInternalServerError)
			return
		}
		w.WriteHeader(http.StatusNoContent)
	}
}

// DELETE
func DeleteUser(db *sql.DB) http.HandlerFunc {
	return func(w http.ResponseWriter, r *http.Request) {
		id := mux.Vars(r)["id"]
		_, err := db.Exec("DELETE FROM user WHERE id=?", id)
		if err != nil {
			http.Error(w, err.Error(), http.StatusInternalServerError)
			return
		}
		w.WriteHeader(http.StatusNoContent)
	}
}
