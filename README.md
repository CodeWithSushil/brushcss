## 🎨🖌️ BrushCSS

[![Tests](https://github.com/CodeWithSushil/brushcss/actions/workflows/tests.yml/badge.svg)](https://github.com/CodeWithSushil/brushcss/actions/workflows/tests.yml)

A PHP-native utility-first CSS engine with JIT compilation, plugin marketplace support, and deep framework integration (Hurricane-ready).

---

### 🚀 What is BrushCSS?

BrushCSS is a backend-driven CSS compiler that scans your PHP/HTML views and generates only the CSS you actually use.

Instead of shipping large static stylesheets, BrushCSS builds CSS on demand (JIT) and integrates directly into your PHP application lifecycle.

---

### ⚡ Key Features

- 🔍 JIT Compilation — Generates CSS only from used classes
- 🧠 View Scanner — Extracts classes from ".php" / ".html" views
- 🔌 Plugin System — Extend utilities and variants easily
- 📦 Composer Ready — Install via Packagist
- 🌪️ Hurricane Integration — Middleware + DI ready
- 🔁 HMR Support — Live CSS reload during development
- 🧱 Grid System (12-column) — Built-in layout engine
- 🎨 Utility-first design system
- 🌐 Remote Plugin Marketplace (CLI "add")

---

### 📦 Installation

```bash
composer require brushcss/brushcss
```

---

### ⚙️ Initialization

`php vendor/bin/brushcss init`

This creates:

* config/brushcss.php
* public/style.css

---

### 🧪 Build CSS

```bash
php vendor/bin/brushcss build
```

---

### 👀 Watch Mode (HMR)

```bash
php vendor/bin/brushcss watch
```

---

### 🔥 Example Usage

View file ("views/login.php").
```html
<h2 class="bg-blue-500 p-4 mt-5">
  Hello BrushCSS
</h2>
```
**Generated CSS:**

```css
.bg-blue-500 { background-color: #3b82f6; }
.p-4 { padding: 16px; }
.mt-5 { margin-top: 20px; }
```
---

### 🧱 Grid System

```html
<div class="grid grid-cols-12 gap-4">
  <div class="col-span-6">Left</div>
  <div class="col-span-6">Right</div>
</div>
```

---

### 🎨 Utility Classes

Spacing

p-4, p-6, mt-5, mb-2

Colors

bg-blue-500, text-red-100

Layout

flex, grid, hidden, block

Effects

transition, duration-300, hover:bg-blue-500

---

### 🔌 Plugin System

BrushCSS supports extensible plugins.

**Install plugin:**

```bash
brushcss add grid
```

**Example plugins:**

- grid system
- typography system
- forms system
- animation system

---

### 🌐 Plugin Marketplace

BrushCSS supports a remote registry:

brushcss add typography

_Internally:_

CLI → Registry API → Composer → Activation → Config injection

---

### 🌪️ Hurricane Integration

BrushCSS can be used inside the Hurricane PHP framework:

**Middleware compilation**

- Auto-scans views per request
- Generates scoped CSS
- Injects into response pipeline

_BrushCSSMiddleware::class_

---

### ⚡ Architecture

View Files
   ↓
Class Extractor
   ↓
JIT Engine
   ↓
Variant Compiler
   ↓
Plugin System
   ↓
CSS Output
   ↓
public/style.css

---

🧠 Advanced Features (Roadmap)

### 🔥 JIT Engine Enhancements

- Incremental builds
- File hashing cache
- Dependency graph tracking

#### ⚡ Variant System

hover:, md:, lg:, dark:

### 🧱 Grid & Layout Engine

- 12-column grid
- flex utilities
- responsive breakpoints

### 🌐 Plugin Marketplace

- versioning
- remote registry
- CLI install/remove/update

### 🔁 HMR WebSocket Server

- instant CSS injection
- no page reload

#### 🧩 Component System (future)

- "<Card />", "<Button />" style UI engine

---

### 🛠️ CLI Commands

brushcss init
brushcss build
brushcss watch
brushcss add <plugin>
brushcss remove <plugin>
brushcss list

---

### 📁 Project Structure

src/
bin/
config/
plugins/
public/
storage/
tests/

---

### ⚠️ Philosophy

BrushCSS is built on one principle:

> “Generate only what you use — nothing more.”

No heavy bundles. No unused CSS. No frontend build dependency.

---

### 🚀 Future Vision

BrushCSS is evolving into:

> A PHP-native styling compiler ecosystem with plugin marketplace and framework-level integration.

Comparable in concept to modern frontend tooling, but fully backend-driven.

---

### 📜 License

MIT License

---

### ✨ Author

Built for modern PHP ecosystems and deep framework integration (Hurricane-ready architecture).
