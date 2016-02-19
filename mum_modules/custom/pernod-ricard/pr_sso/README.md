# drupal-mod-pr_sso
Pernod Ricard Single Sign On Module for Drupal

DESCRIPTION
-----------
This module provide an external authentication from Pernod Ricard Web Service, and can be used with MyPortal.


INSTALLATION
-----
After copying files, enable pr_sso under PERNOD-RICARD section in modules administration.

/!\ IMPORTANT, right after installation fill the "Drupal users allowed to login" in the configuration of the module 
-> admin/config/people/pr_sso
that allows administrators to login without using SSO.


MYPORTAL
--------
If you want to use MyPortal authentication tick the box "Activate MyPortal authentication" 
in the administration of the module and fill the secret key.
A md5 hash of the secret key with the username will be compare to the password.


ROLE ASSIGNMENT
---------------
If you want to use role assignment tick the box "Activate role assignment" in the administration of the module.
Note that role assignment needs another module to works, using the hook "pr_sso_assign_role" with the username as parameter.

