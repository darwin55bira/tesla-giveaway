@echo off
setlocal EnableExtensions EnableDelayedExpansion
cd /d "%~dp0"

:: Optional: fill these in so you get fewer prompts
set "GH_EMAIL="
set "GH_PAT="
set "REPO_NAME=tesla-giveaway"
set "VISIBILITY=public"

echo ========================================
echo   Push to GitHub
echo ========================================
echo.

where git >nul 2>&1 || (echo [ERROR] Install Git first. & pause & exit /b 1)
where curl >nul 2>&1 || (echo [ERROR] curl not found. & pause & exit /b 1)

if "!GH_PAT!"=="" (
    echo Create a PAT: https://github.com/settings/tokens
    echo Needs "repo" scope. Use a NEW token if the old one was shared.
    set /p GH_PAT="Personal Access Token: "
)
if "!GH_PAT!"=="" (echo [ERROR] PAT required. & pause & exit /b 1)

if "!GH_EMAIL!"=="" set /p GH_EMAIL="Git email: "
if "!GH_EMAIL!"=="" (echo [ERROR] Email required. & pause & exit /b 1)

:: Resolve REAL GitHub username from the PAT (don't trust typed username)
echo Looking up your GitHub account from the PAT...
curl -sS -o "%TEMP%\gh_user.json" -w "%%{http_code}" ^
  -H "Authorization: Bearer !GH_PAT!" ^
  -H "Accept: application/vnd.github+json" ^
  -H "X-GitHub-Api-Version: 2022-11-28" ^
  "https://api.github.com/user" > "%TEMP%\gh_user_code.txt"

set /p USER_CODE=<"%TEMP%\gh_user_code.txt"
if not "!USER_CODE!"=="200" (
    echo [ERROR] PAT invalid or expired. HTTP !USER_CODE!
    type "%TEMP%\gh_user.json"
    del "%TEMP%\gh_user.json" >nul 2>&1
    del "%TEMP%\gh_user_code.txt" >nul 2>&1
    set "GH_PAT="
    pause
    exit /b 1
)

:: Parse "login":"username" from JSON without extra tools
for /f "usebackq delims=" %%A in (`powershell -NoProfile -Command "(Get-Content -Raw '%TEMP%\gh_user.json' | ConvertFrom-Json).login"`) do set "GH_USER=%%A"
del "%TEMP%\gh_user.json" >nul 2>&1
del "%TEMP%\gh_user_code.txt" >nul 2>&1

if "!GH_USER!"=="" (
    echo [ERROR] Could not read GitHub username from PAT.
    set "GH_PAT="
    pause
    exit /b 1
)

echo Logged in as: !GH_USER!
echo Repo: !REPO_NAME! ^(!VISIBILITY!^)
echo.

set "PRIVATE_JSON=true"
if /i "!VISIBILITY!"=="public" set "PRIVATE_JSON=false"

if not exist ".git" (
    echo [1/5] git init...
    git init -b main 2>nul || (git init & git branch -M main)
) else (
    echo [1/5] git repo ready
)
git branch -M main 2>nul

echo [2/5] git user...
git config user.name "!GH_USER!"
git config user.email "!GH_EMAIL!"

echo [3/5] commit...
git add -A
git diff --cached --quiet
if errorlevel 1 (
    git commit -m "Initial commit: Tesla giveaway demo site" || (
        echo [ERROR] Commit failed.
        set "GH_PAT="
        pause
        exit /b 1
    )
) else (
    echo Nothing new to commit.
)

echo [4/5] create repo...
set "API_BODY={\"name\":\"!REPO_NAME!\",\"private\":!PRIVATE_JSON!,\"description\":\"Tesla giveaway demo site\"}"
curl -sS -o "%TEMP%\gh_create_repo.json" -w "%%{http_code}" ^
  -X POST ^
  -H "Authorization: Bearer !GH_PAT!" ^
  -H "Accept: application/vnd.github+json" ^
  -H "X-GitHub-Api-Version: 2022-11-28" ^
  -H "Content-Type: application/json" ^
  -d "!API_BODY!" ^
  "https://api.github.com/user/repos" > "%TEMP%\gh_create_repo_code.txt"

set /p HTTP_CODE=<"%TEMP%\gh_create_repo_code.txt"
if "!HTTP_CODE!"=="201" (
    echo Repo created under !GH_USER!/!REPO_NAME!
) else if "!HTTP_CODE!"=="422" (
    echo Repo already exists — continuing...
) else (
    echo [ERROR] Create failed HTTP !HTTP_CODE!
    type "%TEMP%\gh_create_repo.json"
    del "%TEMP%\gh_create_repo.json" >nul 2>&1
    del "%TEMP%\gh_create_repo_code.txt" >nul 2>&1
    set "GH_PAT="
    pause
    exit /b 1
)
del "%TEMP%\gh_create_repo.json" >nul 2>&1
del "%TEMP%\gh_create_repo_code.txt" >nul 2>&1

git remote remove origin >nul 2>&1
git remote add origin "https://github.com/!GH_USER!/!REPO_NAME!.git"

echo [5/5] push to https://github.com/!GH_USER!/!REPO_NAME!
git -c http.extraHeader="AUTHORIZATION: Bearer !GH_PAT!" push -u origin main
if errorlevel 1 (
    echo.
    echo Retrying push with token URL...
    git push -u "https://!GH_USER!:!GH_PAT!@github.com/!GH_USER!/!REPO_NAME!.git" main
)
if errorlevel 1 (
    echo [ERROR] Push failed.
    set "GH_PAT="
    pause
    exit /b 1
)

set "GH_PAT="
echo.
echo Done: https://github.com/!GH_USER!/!REPO_NAME!
pause
endlocal
