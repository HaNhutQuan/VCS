#include <iostream>
#include <fstream>
#include <vector>
#include <string>
#include <sstream>

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

bool getUserInfo(const string &username, string &uid, string &homeDir, string &groupId) {
    ifstream file("/etc/passwd");
    if (!file) return false;
    string line;
    while (getline(file, line)) {
        vector<string> fields = split(line, ':');
        if (fields.size() >= 7 && fields[0] == username) {
            uid = fields[2];
            groupId = fields[3];
            homeDir = fields[5];
            return true;
        }
    }
    return false;
}

vector<string> getUserGroups(const string &username, const string &groupId) {
    ifstream file("/etc/group");
    vector<string> userGroups;
    string primaryGroup;
    if (!file) return userGroups;
    string line;
    while (getline(file, line)) {
        vector<string> fields = split(line, ':');
        if (fields.size() >= 3 && fields[2] == groupId) {
            primaryGroup = fields[0];
        } else if (fields.size() >= 4 && fields[3].find(username) != string::npos) {
            userGroups.push_back(fields[0]);
        }
    }
    if (!primaryGroup.empty()) {
        userGroups.insert(userGroups.begin(), primaryGroup);
    }
    return userGroups;
}

int main() {
    string username;
    cout << "Nhập username: ";
    cin >> username;

    string uid, homeDir, groupId;
    if (getUserInfo(username, uid, homeDir, groupId)) {
        cout << "User: " << username << "\n"
             << "UID: " << uid << "\n"
             << "Home Directory: " << homeDir << "\n"
             << "Groups: ";
        
        vector<string> groups = getUserGroups(username, groupId);
        for (const string &group : groups) {
            cout << group << " ";
        }
        cout << endl;
    } else {
        cout << "Không tìm thấy user!" << endl;
    }
    return 0;
}
