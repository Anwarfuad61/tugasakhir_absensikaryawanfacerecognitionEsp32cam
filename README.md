# Face Recognition Employee Attendance System

![Project Banner](https://github.com/Anwarfuad61/tugasakhir_absensikaryawanfacerecognitionEsp32cam/blob/main/absensikaryawan.JPG)  
🚀 **Automated Employee Attendance System using ESP32-CAM and Face Recognition**

## 📌 Overview
This project implements a web-based **Employee Attendance System** using **ESP32-CAM** for face recognition. The system automatically records attendance by recognizing employees' faces and storing the data in a web-based platform.

## 🎯 Features
✅ **Face Recognition**: Uses ESP32-CAM for real-time face detection and recognition.  
✅ **Web-Based Dashboard**: View and manage attendance data from a centralized web interface.  
✅ **Automatic Attendance Logging**: Employees' presence is logged without manual input.  
✅ **AJAX & jQuery**: Dynamic UI updates without reloading the page.  
✅ **Secure & Efficient**: Ensures reliable and accurate attendance tracking.  

## 🛠️ Tech Stack
- **Hardware**: ESP32-CAM, Camera Module
- **Backend**: PHP, MySQL
- **Frontend**: HTML, CSS, JavaScript (AJAX & jQuery)
- **Communication**: HTTP & API-based data transmission

## 🚀 Getting Started
### 1️⃣ Prerequisites
Ensure you have the following installed:
- Arduino IDE with ESP32 board support
- XAMPP (or similar for running PHP & MySQL)
- Required Arduino libraries (ESP32 WiFi, Face Recognition, etc.)

### 2️⃣ Installation Steps
1. **Clone the Repository**:
   ```bash
   git clone https://github.com/Anwarfuad61/tugasakhir_absensikaryawanfacerecognitionEsp32cam.git
   cd tugasakhir_absensikaryawanfacerecognitionEsp32cam
   ```
2. **Setup the ESP32-CAM**:
   - Open the Arduino IDE and upload the firmware.
   - Configure WiFi credentials in the code.
3. **Setup the Web Server**:
   - Start XAMPP and import the database.
   - Place the web files inside `htdocs`.
4. **Run the System**:
   - Access the web dashboard via `http://localhost/your_project_folder`
   - Power on ESP32-CAM and start recognition.

## 📸 System Workflow
1️⃣ Employee faces the ESP32-CAM.  
2️⃣ The system captures the image and processes it for recognition.  
3️⃣ If matched, attendance is recorded in the database.  
4️⃣ The web dashboard updates dynamically with real-time attendance data.

## 📂 Project Structure
```
📁 tugasakhir_absensikaryawanfacerecognitionEsp32cam
│-- 📂 esp32-cam-code  # ESP32 firmware
│-- 📂 web-dashboard   # Web-based system
│-- 📂 database        # SQL files for MySQL setup
│-- README.md
```

## 📌 Future Enhancements
🔹 Integrate RFID for multi-factor authentication  
🔹 Cloud storage support for remote access  
🔹 Mobile-friendly UI for better accessibility  

## 👤 Author
**Anwar Fuad**  
📧 anwarfuad61@gmail.com  
🔗 [GitHub](https://github.com/Anwarfuad61)

## 🌟 Contribute
Feel free to fork and contribute to improve this system. Pull requests are welcome! 🎉

## 📜 License
This project is licensed under the MIT License.

---
_Developed with ❤️ by Anwar Fuad_

