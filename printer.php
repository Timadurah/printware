<?php
// Replace 'PrinterName' with the name of your shared printer
$printer_name = "\\\\localhost\\POS-58";

// Open a connection to the printer
$handle = fopen($printer_name, "wb");

if (!$handle) {
    die("Could not open printer connection.");
}

// Send raw ESC/POS commands
$commands = [
    "\x1B\x40",                  // Initialize printer
    "Store Name\n",
    "123 Main Street\n",
    "City, State ZIP\n",
    str_repeat("=", 32) . "\n",
    "Item        Qty     Price\n",
    str_repeat("=", 32) . "\n",
    "Coffee       2      $4.00\n",
    "Tea          1      $2.00\n",
    str_repeat("-", 32) . "\n",
    "Total                $6.00\n",
    str_repeat("=", 32) . "\n",
    "Thank you for your purchase!\n",
    "\x1D\x56\x00",              // Cut paper
];

// Send each command to the printer
foreach ($commands as $command) {
    fwrite($handle, $command);
}

// Close the connection to the printer
fclose($handle);
