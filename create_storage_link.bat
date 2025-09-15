@echo off
echo Creating storage link...
rmdir /s /q public\storage
mklink /J public\storage storage\app\public
echo Storage link created successfully!
pause
