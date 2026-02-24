# TGram 🚀

**CLI tool to run your Telegram bot locally without Webhooks**

TGram allows you to **test your Telegram bots locally** without exposing a public webhook. It fetches updates from Telegram using **long polling** and forwards them to your local bot endpoint so you can **develop, debug, and test** your bot easily.

---

## ✨ Features

* Receive Telegram updates on **local environments**.
* Works for **bots using webhooks**, no public URL required.
* Easy configuration using **YAML**.
* CLI interface powered by **Symfony Console**.
* Support for **multiple bots** simultaneously.
* Real-time logs for **debugging and monitoring**.

---

## 💻 Installation

Make sure you have **PHP >= 8.2** and **Composer** installed.

### Linux / macOS

```bash
composer global require iwh3n/tgram
export PATH="$(composer global config bin-dir --absolute | tail -n1):$PATH"  # session-only
```

> ⚠️ This adds TGram **only for the current terminal session**.
> To make it permanent, add the same line to your `~/.bashrc` or `~/.zshrc`:
>
> ```bash
> COMPOSER_GLOBAL_BIN=$(composer global config bin-dir --absolute)
> # for bash:
> echo 'export PATH="$PATH:$COMPOSER_GLOBAL_BIN"' >> ~/.bashrc
> # for zsh:
> echo 'export PATH="$PATH:$COMPOSER_GLOBAL_BIN"' >> ~/.zshrc
> ```

### Windows (PowerShell)

```powershell
composer global require iwh3n/tgram
$env:PATH = "$(composer global config bin-dir --absolute | Select-Object -Last 1);$env:PATH"  # session-only
```

> ⚠️ This adds TGram **only for the current PowerShell session**.
> To make it permanent, use:
>
> ```powershell
> setx PATH "$($env:APPDATA)\Composer\vendor\bin;$env:PATH"
> ```
>
> Then restart your PowerShell.

Verify installation:

```bash
tgram --version
```

---

## ⚙️ Quick Start

1. **Initialize configuration**

```bash
tgram init
```

Example `tgram.yaml`:

```yaml
bot:
  token: "123456789:ABCDEF..."
  endpoint: "http://localhost:8000/bot"
```

2. **Run TGram**

```bash
tgram run
```

TGram will start **long polling Telegram** and forward updates to your local endpoint.

3. **Stop TGram**

```bash
CTRL+C
```

---

## 🛠 Example Workflow

```bash
# Initialize config
tgram init

# Run bot
tgram run
```

Now any message sent to your bot will be received by your **local development server** at the endpoint you configured.

---

## ⚙️ Configuration Options

* `token` – Telegram bot token.
* `endpoint` – Local URL where your bot script listens.

---

## 📊 How It Works

```
Telegram Server → [Long Polling] → TGram CLI → Your Local Bot
```

1. Telegram sends updates → TGram CLI grabs them.
2. TGram forwards updates → Your local bot endpoint.
3. You can **debug, log, and test** locally.

---

Made with ❤️ by H O S S E I N
