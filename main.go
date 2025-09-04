package main

import (
	"drip/app/user"
	"drip/config"
	"fmt"
	"log"
	"net/http"

	"github.com/gorilla/mux"
)

func main() {
	// Load DB connection
	db := config.ConnectDB()
	defer db.Close()

	// Router
	r := mux.NewRouter()

	// User API routes
	r.HandleFunc("/user", user.GetUsers(db)).Methods("GET")
	r.HandleFunc("/user/{id}", user.GetUserByID(db)).Methods("GET")
	r.HandleFunc("/user", user.CreateUser(db)).Methods("POST")
	r.HandleFunc("/user/{id}", user.UpdateUser(db)).Methods("PUT")
	r.HandleFunc("/user/{id}", user.DeleteUser(db)).Methods("DELETE")

	// Start server
	port := ":8080"
	fmt.Printf("🚀 Server running at http://localhost%s\n", port)
	log.Fatal(http.ListenAndServe(port, r))
}
