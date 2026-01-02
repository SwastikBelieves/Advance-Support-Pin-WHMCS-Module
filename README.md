# WHMCS Support PIN Module

[![Version](https://img.shields.io/badge/version-2.01-blue.svg)](https://swastik.dev)
[![License](https://img.shields.io/badge/license-GPL--3.0-green.svg)](LICENSE)
[![WHMCS](https://img.shields.io/badge/WHMCS-Compatible-orange.svg)](https://whmcs.com)

**Empower your support team with instant, secure identity verification.**

The **Support PIN** module for WHMCS streamlines client authentication during voice or chat interactions. By generating a unique, temporary PIN for each client, your support staff can verify account ownership in seconds—eliminating the need for security questions and enhancing the overall customer experience.

## 🚀 Features

*   **Instant Verification**: Generate a unique 4-6 digit PIN for every client automatically.
*   **Client Area Widget**: Conveniently displays the Support PIN in the client area sidebar.
*   **Admin Dashboard Widget**: Allows staff to quickly verify a PIN directly from the WHMCS Admin Home.
*   **One-Click Regeneration**: Clients can easily generate a new PIN if the current one expires or is compromised.
*   **Secure & Lightweight**: PINs are stored securely and the module creates zero overhead on your WHMCS installation.
*   **Fully Customizable**: Built with template support to easily match your WHMCS theme.

## 🛠️ Installation

1.  **Download**: Get the latest version of the module.
2.  **Upload**: Extract and upload the `supportpin` directory to your WHMCS installation at:
    `For WHMCS v8+: /path/to/whmcs/modules/addons/`
3.  **Activate**:
    *   Log in to your WHMCS Admin Area.
    *   Navigate to **System Settings > Addon Modules**.
    *   Find **Support PIN** and click **Activate**.
4.  **Configure**:
    *   Click **Configure** next to the module.
    *   Select the **Access Control** roles (e.g., Full Administrator, Sales, Support) that should have access to manage this module.
    *   Click **Save Changes**.

## 📖 Usage

### For Clients
Once activated, clients will see a new **Support PIN** panel in their Client Area sidebar. They can provide this PIN to your support agents for instant identity verification. A "Generate New PIN" button allows them to refresh their code at any time.

### For Admins
Support staff can verify a client's PIN using the dashboard widget on the Admin Homepage. simply enter the PIN provided by the customer, and the system will confirm the associated client account details.

## ⚙️ Requirements

*   WHMCS v8.0 or later
*   PHP 7.4 or later
*   IonCube Loader (standard with WHMCS requirements)

## 🤝 Support

This module is developed and maintained by **SWASTIK.DEV**.

*   **Website**: [https://swastik.dev](https://swastik.dev)
*   **Issues**: Please report any bugs or feature requests via our support channels.

---

*Copyright &copy; 2026 SWASTIK.DEV. Licensed under GPL-3.0.*
