<!DOCTYPE html>
<html>

<head>
    <title>Encoding</title>
    <link rel="stylesheet" href="220103020_lab9.css" />
</head>

<body>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
        <input type="text" size="40px" name="input" placeholder="Input string" required />
        <br /><br /><br />
        <select name="Base" id="Base" style="font-size: 40px; margin-left: 40%">
            <option value="Base_64">BASE 64</option>
            <option value="Base_32">BASE 32</option>
        </select>
        <br /><br /><br />
        <input type="submit" value="submit" />
    </form>

    <?php
    $inputString = $_GET["input"];
    $selectedBase = $_GET["Base"];
    $encodedString = $inputString;

    function base64DecodeString($inputString): array
    {
        $base64Lookup = array(
            'A' => 0, 'B' => 1, 'C' => 2, 'D' => 3, 'E' => 4, 'F' => 5, 'G' => 6, 'H' => 7,
            'I' => 8, 'J' => 9, 'K' => 10, 'L' => 11, 'M' => 12, 'N' => 13, 'O' => 14, 'P' => 15,
            'Q' => 16, 'R' => 17, 'S' => 18, 'T' => 19, 'U' => 20, 'V' => 21, 'W' => 22, 'X' => 23,
            'Y' => 24, 'Z' => 25, 'a' => 26, 'b' => 27, 'c' => 28, 'd' => 29, 'e' => 30, 'f' => 31,
            'g' => 32, 'h' => 33, 'i' => 34, 'j' => 35, 'k' => 36, 'l' => 37, 'm' => 38, 'n' => 39,
            'o' => 40, 'p' => 41, 'q' => 42, 'r' => 43, 's' => 44, 't' => 45, 'u' => 46, 'v' => 47,
            'w' => 48, 'x' => 49, 'y' => 50, 'z' => 51, '0' => 52, '1' => 53, '2' => 54, '3' => 55,
            '4' => 56, '5' => 57, '6' => 58, '7' => 59, '8' => 60, '9' => 61, '+' => 62, '/' => 63
        );

        $binaryString_8bit = "";
        $binaryString_6bit = "";
        $indexString = "";
        $base64TableString = "";

        for ($i = 0; $i < strlen($inputString); $i++) {
            $char = $inputString[$i];

            $binaryValue_8bit = sprintf('%08b', $base64Lookup[$char]);
            $binaryString_8bit .= $binaryValue_8bit;

            $index = bindec($binaryValue_8bit);
            $indexString .= $index . ' ';

            $binaryValue_6bit = sprintf('%06b', $base64Lookup[$char]);
            $binaryString_6bit .= $binaryValue_6bit;

            $base64TableString .= array_search($index, $base64Lookup) . ' ';
        }

        $paddingLength = strlen($binaryString_6bit) % 8;
        $paddedBinaryString = $binaryString_6bit;

        if ($paddingLength > 0) {
            $padding = str_repeat("0", 8 - $paddingLength);
            $paddedBinaryString .= $padding;
        }

        $byteArrayLength = strlen($paddedBinaryString) / 8;
        $byteArray = [];
        $asciiString = "";

        for ($i = 0; $i < $byteArrayLength; $i++) {
            $byteString = substr($paddedBinaryString, $i * 8, 8);
            $byte = bindec($byteString);
            $byteArray[] = $byte;
            $asciiString .= $byte . ' ';
        }

        $decodedString = utf8_decode(implode(array_map("chr", $byteArray)));

        return array(
            'BinaryString8bit' => $binaryString_8bit,
            'BinaryString6bit' => $binaryString_6bit,
            'IndexString' => $indexString,
            'ASCIIString' => $asciiString,
            'Base64TableString' => trim($base64TableString),
            'DecodedString' => $decodedString
        );
    }

    function base32DecodeString($inputString): array
    {
        $base32Lookup = array(
            'A' => '00000', 'B' => '00001', 'C' => '00010', 'D' => '00011', 'E' => '00100',
            'F' => '00101', 'G' => '00110', 'H' => '00111', 'I' => '01000', 'J' => '01001',
            'K' => '01010', 'L' => '01011', 'M' => '01100', 'N' => '01101', 'O' => '01110',
            'P' => '01111', 'Q' => '10000', 'R' => '10001', 'S' => '10010', 'T' => '10011',
            'U' => '10100', 'V' => '10101', 'W' => '10110', 'X' => '10111', 'Y' => '11000',
            'Z' => '11001', '2' => '11010', '3' => '11011', '4' => '11100', '5' => '11101',
            '6' => '11110', '7' => '11111'
        );

        $binaryString_8bit = "";
        $binaryString_5bit = "";
        $indexString = "";
        $base32TableString = "";

        for ($i = 0; $i < strlen($inputString); $i++) {
            $char = $inputString[$i];

            $binaryValue_5bit = $base32Lookup[$char];
            $binaryString_5bit .= $binaryValue_5bit;

            $index = bindec($binaryValue_5bit);
            $indexString .= $index . ' ';

            $binaryValue_8bit = sprintf('%08b', $index);
            $binaryString_8bit .= $binaryValue_8bit;

            $base32TableString .= array_search($binaryValue_5bit, $base32Lookup) . ' ';
        }

        $paddingLength = strlen($binaryString_5bit) % 8;
        $paddedBinaryString = $binaryString_5bit;

        if ($paddingLength > 0) {
            $padding = str_repeat("0", 8 - $paddingLength);
            $paddedBinaryString .= $padding;
        }

        $byteArrayLength = strlen($paddedBinaryString) / 8;
        $byteArray = [];
        $asciiString = "";

        for ($i = 0; $i < $byteArrayLength; $i++) {
            $byteString = substr($paddedBinaryString, $i * 8, 8);
            $byte = bindec($byteString);
            $byteArray[] = $byte;
            $asciiString .= $byte . ' ';
        }

        $decodedString = utf8_decode(implode(array_map("chr", $byteArray)));

        return array(
            'BinaryString8bit' => $binaryString_8bit,
            'BinaryString5bit' => $binaryString_5bit,
            'IndexString' => $indexString,
            'ASCIIString' => $asciiString,
            'Base32TableString' => trim($base32TableString),
            'DecodedString' => $decodedString
        );
    }

    if ($selectedBase == "Base_64") {
        $result = base64DecodeString($encodedString);

        echo "<br><br>";
        echo "Given String :- $inputString ";
        echo "<br><br>";
        echo "STEP 1 :- ";
        echo "<br><br>";
        echo "First , We need to split the string letter by letter. Thus, we got  ";
        echo "<br><br>";
        echo "String :- " . $result['Base64TableString'] . "<br>";
        echo "<br><br>";
        echo "STEP 2 :- ";
        echo "<br><br>";
        echo "Each Base64 character has its own index, and now our task is to convert those characters to indices. ";
        echo "To do this, By mapping values from the Base64 Characters Table replace each character by its index. ";
        echo "All in all, We should get the following indices :-";
        echo "<br><br>";
        echo PHP_EOL . "String :- " . $result['IndexString'];
        echo "<br><br>";
        echo "STEP 3 :- ";
        echo "<br><br>";
        echo "At this step, We should convert each decimal to binary. So find corresponding decimal values in the ASCII table and make sure we get the following binary string :- ";
        echo "<br><br>";
        echo PHP_EOL . "String :- " . $result['BinaryString8bit'];
        echo "<br><br>";
        echo "STEP 4 :- ";
        echo "<br><br>";
        echo "Now remove the prefix “00” (two zeros) in front of each binary value and simply perform concatenation of those binary values in the binary string :- ";
        echo "<br><br>";
        echo PHP_EOL . "String :- " . $result['BinaryString6bit'];
        echo "<br><br>";
        echo "STEP 5 :- ";
        echo "<br><br>";
        echo "Divide the resulting string into groups so that each one has 8 characters, Then convert those 8-bit binary values to decimal ";
        echo "String :- " . $result['ASCIIString'] . "<br>";
        echo "<br><br>";
        echo "STEP 6 :- ";
        echo "<br><br>";
        echo "Convert all decimal values into their ASCII characters :- ";
        echo "<br><br>";
        echo "String: " . trim($result['ASCIIString']) . "<br>";
        echo "<br><br>";
        echo "STEP 7 :- ";
        echo "<br><br>";
        echo "The final chord, concatenate all ASCII characters to get the result string:- ";
        echo "<br><br>";
        echo "Decoded String: " . $result['DecodedString'] . "\n";
        echo "<br><br>";
    } elseif ($selectedBase == "Base_32") {
        $result = base32DecodeString($encodedString);
        echo "<br><br>";
        echo "Given String :- $encodedString\n";
        echo "<br><br>";
        echo "STEP 1 :- ";
        echo "<br><br>";
        echo "First , We need to split the string letter by letter. Thus, we got  ";
        echo "<br><br>";
        echo "String :- " . $result['Base32TableString'] . "<br>";
        echo "<br><br>";
        echo "STEP 2 :- ";
        echo "<br><br>";
        echo "Each Base32 character has its own index, and now our task is to convert those characters to indices. ";
        echo "To do this, By mapping values from the Base32 Characters Table replace each character by its index. ";
        echo "All in all, We should get the following indices :-";
        echo "<br><br>";
        echo PHP_EOL . "String :- " . $result['IndexString'];
        echo "<br><br>";
        echo "STEP 3 :- ";
        echo "<br><br>";
        echo "At this step, We should convert each decimal to binary. So find corresponding decimal values in the ASCII table and make sure we get the following binary string :- ";
        echo "<br><br>";
        echo PHP_EOL . "String :- " . $result['BinaryString8bit'];
        echo "<br><br>";
        echo "STEP 4 :- ";
        echo "<br><br>";
        echo "Now remove the prefix “000” (three zeros) in front of each binary value and simply perform concatenation of those binary values in the binary string :- ";
        echo "<br><br>";
        echo PHP_EOL . "String :- " . $result['BinaryString5bit'];
        echo "<br><br>";
        echo "STEP 5 :- ";
        echo "<br><br>";
        echo "Divide the resulting string into groups so that each one has 8 characters, Then convert those 8-bit binary values to decimal ";
        echo "String :- " . $result['ASCIIString'] . "<br>";
        echo "<br><br>";
        echo "STEP 6 :- ";
        echo "<br><br>";
        echo "Convert all decimal values into their ASCII characters :- ";
        echo "<br><br>";
        echo "String: " . trim($result['ASCIIString']) . "<br>";
        echo "<br><br>";
        echo "STEP 7 :- ";
        echo "<br><br>";
        echo "The final chord, concatenate all ASCII characters to get the result string:- ";
        echo "<br><br>";
        echo "Decoded String: " . $result['DecodedString'] . "\n";
        echo "<br><br>";
    }

    ?>
</body>

</html>