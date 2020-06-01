# alma-self-checkout
Allows library patrons to check out items on their own.  Utilizes ALMA and CAS.


1. Make a copy of config.example.php named config.php.
2. Fill in the missing values of config.php.
3. If your institution does not use CAS, rewrite login to use your login method.  The user id that is sent to ALMA should be created in this script and be named $user_id.
4. Rewrite header.php and footer.php to look like your institutions.
5. Clean up the css in index.php if needed.  It should work fine with bootstrap 4 based systems.
