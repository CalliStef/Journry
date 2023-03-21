

## How to Run the App

### 1. Clone the Repo
```bash
git clone https://github.com/CalliStef/php-term-project.git
cd php-term-project
```

### 2. Install dependencies
```bash
npm i
composer install
```

### 3. On a separate Terminal, Run Tailwind Build watch command for Development.
```bash
npm run tailwind-watch
```

### 4. Setup your .env
Make a copy of the `.env.example` like below. Then start configuring your environment variables.
```bash
cp .env.example .env
```

### 5. Run the app (using valet)
```bash
# using valet
valet link
```

### 5.1 Not using valet
- Map your server to host the root folder.