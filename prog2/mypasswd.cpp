#include <iostream>
#include <fstream>
#include <vector>
#include <string>
#include <sstream>
#include <unistd.h>
#include <crypt.h>
#include <random>
using namespace std;

vector<string> split(const string &str, char delimiter) {
    vector<string> tokens;
    stringstream ss(str);
    string token;
    while (getline(ss, token, delimiter)) {
        tokens.push_back(token);
    }
    return tokens;
}

string findUser(const string& uid) {
    ifstream file("/etc/passwd");
    if (!file) {
        cout << "Không thể mở /etc/passwd!" << endl;
        exit(1);
    }

    string line;
    while(getline(file, line)) {
        vector<string> fields = split(line, ':');
        if(!fields.empty() && uid == fields[2]) {
            return fields[0]; // return username
        }
    }

    return "";
}

string getShadowEntry(const string &username) {
    ifstream file("/etc/shadow");
    if (!file) {
        cout << "Không thể mở /etc/shadow!" << endl;
        exit(1);
    }

    string line;
    while (getline(file, line)) {
        vector<string> fields = split(line, ':');
        if (!fields.empty() && fields[0] == username) {
            return line;
        }
    }

    return "";
}

bool verifyPassword(const string &inputPassword, const string &shadowEntry) {
    vector<string> fields = split(shadowEntry, ':');
    if (fields.size() < 2) return false;

    // $<id>$<salt>$<hash>
    string storedHash = fields[1];
    string salt = storedHash.substr(0, storedHash.find_last_of('$'));
    string inputHash = crypt(inputPassword.c_str(), salt.c_str());

    return inputHash == storedHash;
}

string generateSalt() {
    string charset = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
    string saltValue = "$6$"; // SHA-512 prefix
    
    for (int i = 0; i < 16; i++) {
        saltValue += charset[rand() % charset.size()];
    }
    
    return saltValue;
}

void updatePassword(const string &username, const string &newPassword) {
    string newSalt = generateSalt();
    string newHash = crypt(newPassword.c_str(), newSalt.c_str());

    ifstream file("/etc/shadow");
    ofstream tempFile("/etc/shadow.tmp");

    if (!file || !tempFile) {
        cout << "Lỗi truy cập file!" << endl;
        exit(1);
    }

    string line;
    while (getline(file, line)) {
        vector<string> fields = split(line, ':');
        if (!fields.empty() && fields[0] == username) {
            fields[1] = newHash;
            line = fields[0] + ":" + fields[1] + ":" + fields[2] + ":" + fields[3] + ":" + fields[4] + ":" + fields[5] + ":" + fields[6] + "::";
        }
        tempFile << line << endl;
    }

    file.close();
    tempFile.close();
    rename("/etc/shadow.tmp", "/etc/shadow");
}

int main() {
    string username = findUser(to_string(getuid()));
    if (username.empty()) {
        cout << "Không thể xác định username!" << endl;
        return 1;
    }

    string shadowEntry = getShadowEntry(username);
    if (shadowEntry.empty()) {
        cout << "Không tìm thấy thông tin user!" << endl;
        return 1;
    }
    
    string oldPassword, newPassword;
    cout << "Nhập mật khẩu cũ: ";
    cin >> oldPassword;
    if (!verifyPassword(oldPassword, shadowEntry)) {
        cout << "Mật khẩu cũ không đúng!" << endl;
        return 1;
    }
    
    cout << "Nhập mật khẩu mới: ";
    cin >> newPassword;
    updatePassword(username, newPassword);
    
    cout << "Mật khẩu đã được thay đổi thành công!" << endl;
    return 0;
}
