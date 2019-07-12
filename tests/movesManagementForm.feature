Feature: Moves Management Activity Creation Form

Scenario: Adding a basic activity thru the Form

 Given "Alex Abba" is in the 'Development Officers' User Group
 And goes to the Moves Management Activity Creation Form
 And enters Activity Type - "Phone Call"
 And selects  "Billy Bob" for Contact Name
 And selects 5/11/2019 for Date Added
 And selects "Susan Ryan" for Assigned to
 And selects 5/21/2019 for Date Scheduled
 And selects "Cat Curry" for Activity Suggested by
 And selects "Pending" for Activity Status
 And selects 5/11/2019 for activity status updated date
 And selects ask made "Planned Gift"
 And enters ask amount "$50.00"
 And enters "First Try" into the text area for Additional Notes
 Then an activity of type "Phone call" will be created
 And its Added by contact will be "Alex Abba"
 And its With Contact will be "Billy Bob"
 And its Assigned to contact wil be "Susan Ryan"
 and its Date will be 5/21/2019
 and its Date Added will be 5/11/2019
 And its Activity Suggested by will be "Cat Curry"
 And its Activity Status will be "Pending"
 And in the Activity Status Change Table a row will be created with the values Status changed to "Pending", Status updated date 5/11/2019.
 And its Ask made field will be populated as "planned gift"
 And its Ask amount field will be populated as $50.00
 And its details field will be populated as "First try"

 Scenario: Adding an activity tof type "Other"

  Given "Alex Abba" is in the 'Development Officers' User Group
  And goes to the Moves Management Activity Creation Form
  And enters Activity Type - "Other"
  Then the field Other Activity Type will appear for which the data will be mapped to the custom field "Other Activity Type"

Scenario: Adding an activity thru the Form with the status of "On Hold" or "Canceled"

  Given "Alex Abba" is in the 'Development Officers' User Group
  And goes to the Moves Management Activity Creation Form
  And selects the Activity Status "On Hold" or "Canceled"
  Then a "Reason" field will appear for which data will be saved to the 'civicrm_activity_status_change' table

Scenario: Adding a Follow Up activity thru the Form

  Given "Alex Abba" is in the 'Development Officers' User Group
  And goes to the Moves Management Activity Creation Form
  And clicks the "Add Follow Up activity" button
  Then the fields for adding a follow up activity will appear below (Three activities can be added this way).
