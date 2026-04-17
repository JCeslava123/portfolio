# 🚀 PHP Portfolio — Render Deployment Guide

## 📁 Project Structure

```
portfolio/
├── index.php          ← Main portfolio page
├── api/
│   └── projects.php   ← JSON API endpoint
├── data/
│   └── projects.json  ← YOUR project data (edit this!)
├── Dockerfile         ← Render deployment config
├── .htaccess          ← Apache URL rules
└── README.md
```

## ✏️ How to Customize

1. Open `data/projects.json`
2. Update your name, bio, email, GitHub, LinkedIn
3. Add/edit your projects in the `projects` array
4. Update your `skills` list

---

## 🖥️ Deploy to Render — Step by Step

### Step 1 — Push to GitHub
1. Create a new repo on github.com
2. Run these commands in your project folder:
```bash
git init
git add .
git commit -m "Initial portfolio"
git branch -M main
git remote add origin https://github.com/YOUR_USERNAME/YOUR_REPO.git
git push -u origin main
```

### Step 2 — Create Render Account
- Go to https://render.com
- Sign up (use your GitHub account for easy linking)

### Step 3 — Create New Web Service
1. Click **"New +"** → **"Web Service"**
2. Connect your GitHub account
3. Select your portfolio repository
4. Click **"Connect"**

### Step 4 — Configure the Service
Fill in these settings:
- **Name:** my-portfolio (anything you like)
- **Region:** Pick closest to you
- **Branch:** main
- **Runtime:** Docker  ← IMPORTANT
- **Instance Type:** Free

Leave everything else as default.

### Step 5 — Deploy!
- Click **"Create Web Service"**
- Wait 2–3 minutes for the build
- Your site will be live at: `https://your-app-name.onrender.com`

---

## 🔄 How to Update Your Portfolio Later

Just push to GitHub — Render auto-deploys:
```bash
git add .
git commit -m "Added new project"
git push
```

That's it! Render detects the push and rebuilds automatically.
