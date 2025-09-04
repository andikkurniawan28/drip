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
	db := config.ConnectDB()
	defer db.Close()

	r := mux.NewRouter()

	// Middleware CORS & trailing slash
	r.Use(mux.CORSMethodMiddleware(r))
	r.Use(func(next http.Handler) http.Handler {
		return http.HandlerFunc(func(w http.ResponseWriter, r *http.Request) {
			// CORS
			w.Header().Set("Access-Control-Allow-Origin", "*")
			w.Header().Set("Access-Control-Allow-Methods", "GET, POST, PUT, DELETE, OPTIONS")
			w.Header().Set("Access-Control-Allow-Headers", "Content-Type, X-Requested-With, Authorization")

			// Preflight request
			if r.Method == http.MethodOptions {
				w.WriteHeader(http.StatusOK)
				return
			}

			// Remove trailing slash
			if r.URL.Path != "/" && r.URL.Path[len(r.URL.Path)-1] == '/' {
				r.URL.Path = r.URL.Path[:len(r.URL.Path)-1]
			}

			next.ServeHTTP(w, r)
		})
	})

	// User routes
	r.HandleFunc("/user", user.GetUsers(db)).Methods("GET")
	r.HandleFunc("/user/{id}", user.GetUserByID(db)).Methods("GET")
	r.HandleFunc("/user", user.CreateUser(db)).Methods("POST")
	r.HandleFunc("/user/{id}", user.UpdateUser(db)).Methods("PUT")
	r.HandleFunc("/user/{id}", user.DeleteUser(db)).Methods("DELETE")

	port := ":8080"
	fmt.Printf("🚀 Server running at http://localhost%s\n", port)
	log.Fatal(http.ListenAndServe(port, r))
}
