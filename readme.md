# Base64 and Base32 Encoding/Decoding

This is a web application built using HTML, CSS, and PHP that allows users to input a string and encode or decode it using Base64 or Base32 encoding schemes. The application provides a step-by-step explanation of the encoding/decoding process, making it a useful educational tool for understanding these encoding schemes.

# About

This project is a lab assignment for the course Web Technology (CS2015) taught by Dr Navanath Saharia at the Indian Institute of Information Technology (IIIT), Manipur. It is designed to demonstrate the practical application of web development technologies like HTML, CSS, and PHP.

## Features

- User-friendly interface with input fields and dropdown menus
- Support for Base64 and Base32 encoding/decoding
- Step-by-step explanation of the encoding/decoding process
- Display of intermediate results (binary strings, index strings, ASCII strings, etc.)
- Final decoded string output

## How to Use

1. Open the application in a web browser.
2. Enter the string you want to encode/decode in the input field.
3. Select the desired encoding scheme (Base64 or Base32) from the dropdown menu.
4. Click the "Submit" button.
5. The application will display the step-by-step encoding/decoding process and the final decoded string.

## Code Structure

The code is divided into two parts: HTML and PHP.

### HTML Part

The HTML part contains the structure and layout of the web page, including input fields, dropdown menus, and styling using CSS. It also includes a form that submits the user input to the PHP script for processing.

### PHP Part

The PHP part consists of two main functions: `base64DecodeString` and `base32DecodeString`. These functions take the user's input string and perform the respective encoding/decoding process, following these steps:

1. Split the input string into individual characters.
2. Convert each character to its corresponding index value based on the Base64 or Base32 character table.
3. Convert the index values to binary strings.
4. Concatenate the binary strings and pad them if necessary.
5. Split the binary string into 8-bit chunks and convert them to decimal values (ASCII codes).
6. Convert the ASCII codes to characters and concatenate them to form the decoded string.

The PHP code also handles the user's form submission and selects the appropriate function (Base64 or Base32) based on the selected encoding scheme. It then displays the step-by-step process and the final decoded string.

## Dependencies

- Web server with PHP support (e.g., Apache, Nginx)

## Contributing

Contributions to this project are welcome. If you find any bugs or have suggestions for improvements, please open an issue or submit a pull request.

## License

This project is licensed under the [MIT License](LICENSE).
