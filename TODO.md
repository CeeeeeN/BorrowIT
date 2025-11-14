# TODO: Fix Admin Approval Database Updates

## Steps to Complete

1. **Update admin_approval.php for Pending Admins Form** ✅
   - Change form action from 'mark_returned.php' to 'admin_status.php' for Approve/Deny buttons.

2. **Update admin_approval.php for Existing Admins Form** ✅
   - Change form action to 'admin_status.php' for Save Changes button.
   - Move the AccountType select inside the form and add name="AccountType".

3. **Implement AccountStatus Update in admin_status.php** ✅
   - Handle POST for AccountStatus: Update admin status to 'Approved' (value 2) or 'Denied' (value 3).

4. **Implement AccountUpdate in admin_status.php** ✅
   - Handle POST for AccountUpdate: Update AccountType for existing admins.

5. **Add Redirect in admin_status.php** ✅
   - After successful update, redirect back to admin_approval.php.

6. **Test the Updates** ✅
   - Verify that clicking Approve/Deny updates the database correctly.
   - Verify that changing AccountType and saving updates the database.
   - Verify that password input shows hashed password and role select shows current role.
   - Verify that saving changes updates password (if changed) and AccountType in database.
