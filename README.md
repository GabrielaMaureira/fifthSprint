# fifthSprint
REST API Laravel.  
Swagger documentation available at `/api/documentation`.

## 🎲 Dice Game
If both add up to 7, you win; otherwise, you lose.

---

## 🚀 Installation (Dockerized Setup)

### **1️⃣ Clone the repository**
```sh
git clone https://github.com/GabrielaMaureira/fifthSprint.git
cd dicesGame
```

### **2️⃣ Set up environment variables**
Copy the `.env.example` file to `.env` and modify the database credentials if needed:
```sh
cp .env.example .env
```

### **3️⃣ Start the application using Docker**
```sh
make build   # Build the containers (only needed the first time)
make up      # Start the containers
```

💡 **This will launch:**
- `nginx` (listening on port `8000`)
- `PHP-FPM` (running Laravel)
- `MySQL` (storing data)

### **4️⃣ Access the application**
Once the containers are running, visit:
- **API Base URL** → [http://localhost:8000](http://localhost:8000)
- **Swagger Documentation** → [http://localhost:8000/api/documentation](http://localhost:8000/api/documentation)

---

## 🔧 Available Commands
You can manage the app using `make` commands:

| Command       | Description                                  |
|--------------|--------------------------------------------|
| `make build`  | Build Docker images (first-time setup)   |
| `make up`     | Start the application (Docker containers) |
| `make down`   | Stop and remove containers and volumes   |
| `make stop`   | Stop running containers without removing them |
| `make start`  | Restart stopped containers               |
| `make shell`  | Open a shell inside the Laravel container |

---

