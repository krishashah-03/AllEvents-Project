# 🎵 Artist Discovery Engine

An AI-powered music artist search and recommendation platform that lets users explore artists, get smart suggestions (even with typos!), and discover related musicians based on genre. Built using **React**, **PHP**, **MySQL**, and **FastAPI**.

---

## 📊 Project Overview

Users can:
- Enter a username to begin their journey
- Select at least 3 music genres they love
- Explore artists filtered by genre
- Search with intelligent typo-tolerant queries
- View artist details and get recommendations

---

## 🔧 Tech Stack

| Layer         | Technology                    |
|---------------|-------------------------------|
| Frontend      | React, Tailwind CSS, Framer Motion |
| Backend       | PHP, MySQL                    |
| Search Engine | Python, FastAPI, RapidFuzz    |
| Development   | XAMPP, Git, VS Code           |

---

## 🛁 Folder Structure

```
ALLEVENTS-PROJECT/
├── backend/              # PHP API (hosted on XAMPP)
├── frontend/             # React app
├── python-search/        # FastAPI fuzzy search server
└── index.php             # Entry if needed (optional)
```

---

## 🚀 Setup Instructions

### 1. Clone the Repository
```bash
git clone https://github.com/your-username/Artist-Discovery-Engine.git
cd Artist-Discovery-Engine
```

### 2. Setup PHP Backend
- Move `backend/` to: `C:/xampp/htdocs/ALLEVENTS-BACKEND/`
- Start **Apache** and **MySQL** via XAMPP
- Import the database from `backend/database.sql` using phpMyAdmin

### 3. Start React Frontend
```bash
cd frontend
npm install
npm start
```
- Access it at: `http://localhost:3000`

### 4. Start Python Search API
```bash
cd python-search
pip install -r requirements.txt
uvicorn app:app --reload
```
- API runs on: `http://127.0.0.1:8000/search?q=Adele`

---

## 📉 Intelligent Search Examples

| Query          | Corrected Suggestion   |
|----------------|------------------------|
| Tailor Swift   | Taylor Swift           |
| EdSheeren      | Ed Sheeran             |
| Cold Play      | Coldplay               |
| MJ             | Michael Jackson        |
| TheWeek        | The Weeknd             |
| Ariana Grandi  | Ariana Grande          |

---



