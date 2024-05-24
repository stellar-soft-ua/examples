Overview
The "Add New Client" form is a web-based interface designed to facilitate the addition of new client entries into database. This form collects essential client information, ensuring that client records are comprehensive and up-to-date.

Form Fields
The form contains several fields where you can input the client's information. Below is a detailed list of each field, its description, and any validation rules applied using react-hook-form.

- Company Name
Field Name: formData.companyName
Description: The name of the company the client is associated with.
Type: Text
Validation: Required. Must be between 2 and 100 characters.

- Currency
Field Name: formData.currency
Description: The preferred currency for transactions.
Type: Dropdown
Validation: Required.

- First Name
Field Name: formData.firstName
Description: The first name of the client.
Type: Text
Validation: Required. Must be between 2 and 50 characters.

- Last Name
Field Name: formData.lastName
Description: The last name of the client.
Type: Text
Validation: Required. Must be between 2 and 50 characters.

- Email Address
Field Name: formData.email
Description: The client's email address.
Type: Email
Validation: Required. Must be a valid email format (e.g., name@domain.com).

- Company ID
Field Name: selectedCompany.CompanyID
Description: The unique identifier for the company.
Type: Hidden/Pre-selected
Validation: Required.

- Address Line 1
Field Name: formData.address1
Description: The first line of the client's address.
Type: Text
Validation: Optional.

- Address Line 2
Field Name: formData.address2
Description: The second line of the client's address.
Type: Text
Validation: Optional.

- Admin Note
Field Name: formData.note
Description: Any additional notes about the client.
Type: Textarea
Validation: Optional.

- City
Field Name: formData.city
Description: The city where the client is located.
Type: Text
Validation: Optional.

- Country
Field Name: formData.country
Description: The country where the client is located.
Type: Dropdown
Validation: Optional.

- Phone Number
Field Name: formData.phone
Description: The client's contact phone number.
Type: Number
Validation: Optional. If provided, must be a valid phone number format (e.g., +1-234-567-8900).

- State
Field Name: formData.state
Description: The state where the client is located.
Type: Text
Validation: Optional.

- Zip Code
Field Name: formData.zip
Description: The postal code for the client's address.
Type: Text
Validation: Optional.

Submission
When the form is submitted, the data is sent to the server via a POST request. The server processes this data and adds the new client entry to the database. If any required fields are missing or contain invalid data, the form will display appropriate error messages prompting the user to correct the input.

Error Handling
The form includes client-side validation using react-hook-form to ensure that all required fields are completed correctly before submission. In case of server-side errors, an error message will be displayed to the user, and the form data will be preserved to prevent data loss.

Usage
1. Navigate to the "Add New Client" form from the application menu.
2. Enter the client's information into the appropriate fields, ensuring all required fields are completed.
3. Click the "Submit" button at the bottom of the form. Review any error messages and correct any invalid or missing data. Upon successful submission, a confirmation message will appear, and the new client entry will be added to the database.