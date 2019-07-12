# com.aghstrategies.movesmanagement

## Custom form for recording Moves Management activities

Create a form that is accessible for 'Development Officers' User Group that has the following fields:

+ Activity Type - Select (what ever options they want us to offer).
  + Other Activity Type (Hidden unless Other is selected for Activity Type) - Free Text
+ Contact Name - Contact Reference
+ Date Added - Date field, defaults to today but can be edited.
+ Assigned to - Contact Reference that allows multiple people to be selected and defaults to Susan Ryan
+ Date Scheduled - Date field
+ Activity Suggested By - Contact Reference
+ Activity Status - Select with options: "Pending", "On Hold", "Completed", "Canceled"
  + Reason for activity status - text field that only shows if the user selects "On Hold" or "Canceled"
  + Status Updated Date - Date field, defaults to today's date but editable.
+ Additional Notes - Text Area
+ Attachments - 3 attach File Fields
+ Repeat Activity? - checkbox if selected display fields listed below:
  + Repeats Every - Number field and day/week/hour etc.
  + Repeats On - Checkboxes for days of the week
  + Start Date - Date field
  + Ends - Radio for after X occurrences or On xx Date
  + Exclude Dates - Multi Date select field
+  Ask Made - Select with the following options: "Individual Contribution", "Foundation Proposal", "Planned Gift", "Other"
  + Other type of Ask Made - Only shows up if Other selected for Ask made field, free text
  + Ask Amount - only shows up if value selected for Ask Made. Money field
+ Add Follow up Activity? - button when clicked reveals fields for another Activity with all the fields listed above (can be clicked 3 times to add up to 3 additional activities) with the Contact Name defaulting to the Contact Name selected on the initial activity.

On Submission of this form Activities (may be creating up to 4 activities depending on how many Follow up Activities have been added) will be created with fields populated as follows:

+ Activity Type - As selected in the Activity Type field, if Other is selected then an Activity Type will be created as defined in the "Other Activity Type" field.
+ Added By - User filling out the form
+ With Contact - Contact selected in the Contact Name field.
+ Assigned to - value selected in Assigned To field
+ Date - value selected in Date Scheduled field
+ Date Added - value selected for Date Added
+ Activity Suggested By - Contact Reference Custom Field that needs to be created "Activity Suggested By"
+ Activity Status - Activity Status field  
  *We are going to create a table in the database for tracking activity status changes (more info in the "Tracking the date/time and status change of activities" section), every time an activity status is changed (including on create) a row will be added to that table with the following columns (a little table will appear on the activity to show these values):*
  + Activity Status Changed to - value in Activity Status field
  + Status Updated Date - value in Status Updated Date field
  + Reason - value entered in Reason for activity status field
  + Activity Id - Autopopulated as id of this activity
+ Details - value entered in the Additional Notes field
+ Attachments - uploaded files in the Attachments fields
+ Repeat Activity -- mapped to same fields in repeat activity fields section
+ Ask Made - Custom select field that needs to be created "Ask Made"
+ Other type of Ask Made - Custom text field that needs to be created.
+ Ask Amount - Custom Money field that needs to be created

## Tracking the date/time and status change of activities

We will create a custom table in the database called `civicrm_activity_status_change` with columns for:
  + Id of row in table
  + Activity Id
  + Activity Status Changed to
  + Status Updated Date
  + Reason

Whenever the Activity status is changed for any activity we will record an entry to that table. When an activity is created we will record a row in that table. We will display a mini table on each activity that shows all the activity status change data for that activity. In edit mode of an activity Admin users will be able to add and delete rows from the table.

## Custom report for tracking Activity Status Changes

We will create a new custom report template that:

Has the following Column Options:

+ Activity Added By
+ Date Added
+ Date Scheduled
+ Activity Type
+ Activity Suggested By
+ Contact Name
+ Details
+ Activity Assigned To
+ Activity Status
+ Activity Status Date Changed

And is searchable by when the Activity Status Last Changed.
