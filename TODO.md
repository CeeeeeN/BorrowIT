# TODO: Implement Quantity Deduction on Borrow Approval

## Steps to Complete
- [x] Modify borrow_status.php to deduct quantity from inventory when admin approves a borrow request
- [x] Add logic to fetch item_name and quantity_borrowed from student_borrow_logs
- [x] Update inventory table by subtracting quantity_borrowed from the matching item's quantity
- [x] Add error handling for cases where inventory quantity is insufficient or item not found
- [ ] Test the approval process to ensure quantity is correctly deducted
