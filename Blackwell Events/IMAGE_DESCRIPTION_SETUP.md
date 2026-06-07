# Image Description Feature Setup

This document describes how to add image descriptions to pictures posted on the Blackwell Events platform.

## What Was Changed

The following modifications were made to support image descriptions:

### 1. **Database**
- Added `image_description` column to the `events` table (LONGTEXT)
- This allows storing descriptive text for each event's flyer/image

### 2. **Admin Panel - Add Event** (`admin/add-event.php`)
- Added a new form field: "Image Description" (textarea)
- Updated the database insert query to include the `image_description` field
- Users can now add descriptions when creating new events

### 3. **Admin Panel - Edit Event** (`admin/edit.php`)
- Added a "Image Description" textarea field
- Updated the database update query to allow editing existing descriptions
- Users can now update descriptions for existing events

### 4. **Public View** (`view-event.php`)
- Added display of image descriptions below the event flyer
- Descriptions are shown in italics with styled formatting
- Only displays if a description exists

### 5. **Styling** (`assets/css/style.css`)
- Added `.image-description` CSS class for beautiful formatting
- Styled with accent color border and soft background

## Setup Instructions

### Step 1: Add Database Column

Run one of these methods:

#### Method A: Using PHP Setup Helper (Easiest)
1. Open your browser and navigate to:
   ```
   http://localhost/Blackwell%20Events/database/setup-image-description.php
   ```
2. The script will add the column if it doesn't exist and confirm with a checkmark (✓)

#### Method B: Using phpMyAdmin
1. Open phpMyAdmin
2. Select the `christmas_db` database
3. Select the `events` table
4. Click "Structure"
5. Click "Add" to add a new column
6. Fill in these details:
   - Name: `image_description`
   - Type: `LONGTEXT`
   - Click "Save"

#### Method C: Using SQL Query
1. Open phpMyAdmin
2. Go to SQL tab
3. Run this query:
   ```sql
   ALTER TABLE events ADD COLUMN image_description LONGTEXT;
   ```

### Step 2: Verify Installation

1. Go to Admin Panel → Add New Event
2. You should see a new "Image Description" field below the flyer input
3. Try adding a new event with a flyer and description
4. View the event on the public site to see the description displayed

### Step 3: Edit Existing Events

For events already posted:
1. Go to Admin Dashboard
2. Edit an existing event
3. Scroll down to find the "Image Description" field
4. Add or update the description
5. Click "Update"

## Usage

### When Adding New Events
1. Upload the event flyer
2. In the "Image Description" field, provide context about the image
3. Examples:
   - "Annual Christmas celebration with live performances"
   - "Professional networking event in downtown venue"
   - "Family-friendly outdoor concert series"

### When Viewing Events
- The description appears below the flyer image
- It's styled with an accent color border
- Helps users understand what they're seeing in the image

## Files Modified

1. `admin/add-event.php` - Added form field and database insert
2. `admin/edit.php` - Added form field and database update
3. `view-event.php` - Added display of image description
4. `assets/css/style.css` - Added styling for descriptions

## Files Created

1. `database/setup-image-description.php` - Automated setup helper
2. `database/migration_add_image_description.sql` - SQL migration script

## Troubleshooting

### "Image Description" field not showing?
- Make sure you cleared your browser cache (Ctrl+F5 or Cmd+Shift+R)
- Verify the files were updated correctly

### Description not saving?
- Check that the database column was added successfully
- Verify database connection in `database/config.php`
- Check browser console for any JavaScript errors

### Error when running setup helper?
- Ensure `config.php` database connection is working
- Check that you have proper database permissions
- Try using phpMyAdmin method instead

## Future Enhancements

Consider adding:
- Multiple images per event
- Image gallery feature
- Image alt text for accessibility
- Image captions

---

**For questions or issues, check that all files are updated and the database column exists.**
