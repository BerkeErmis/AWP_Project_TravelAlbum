# Gezi Albümü (Travel Album)

This is a Laravel-based web application for creating and sharing travel albums. Users can browse trips, view trip details with photo galleries, and switch between Turkish and English languages. The project features a clean, user-friendly interface and supports admin-only trip creation.

## Features

- **Homepage List View:**  
  The homepage displays a simple, clickable list of all trips. Each row shows the trip’s title, description, and date. Clicking a trip navigates to its detail page.

- **Trip Detail Page:**  
  Each trip detail page displays all associated photos. Clicking a photo opens it in a fullscreen modal with a caption and close button.

- **Localization (Language Switching):**  
  The application supports Turkish and English. Users can switch languages using the TR/EN buttons, which update all static UI texts and highlight the current selection.

- **Admin Trip Creation:**  
  An admin-only “Add New Trip” button is available on the homepage for creating new trips.

- **Translatable UI:**  
  All static interface texts (e.g., “Travel Album”, “Add New Trip”, “Login”, “Register”) are translatable and update according to the selected language.

- **Responsive Design:**  
  The UI is designed to be clean and accessible on both desktop and mobile devices.

## Technical Highlights

- **Laravel Framework:**  
  Utilizes Laravel’s MVC structure, routing, middleware, and localization features.

- **Blade Templates:**  
  All views are built with Blade, ensuring maintainable and readable UI code.

- **Storage and Image Handling:**  
  Images are stored and served via Laravel’s storage system, ensuring secure and correct file access.

- **Middleware for Localization:**  
  Locale middleware is applied to all web routes, ensuring consistent language switching across the application.

## Completed Tasks

- Migrated homepage logic to a controller for proper middleware support.
- Implemented a simple, clickable trip list on the homepage (no images).
- Built trip detail pages with clickable, fullscreen photo modals.
- Added and configured language switcher for Turkish/English.
- Made all static UI texts translatable and updated translation files.
- Ensured admin-only access to the “Add New Trip” button.
- Debugged and fixed issues with image display, storage links, and localization.


