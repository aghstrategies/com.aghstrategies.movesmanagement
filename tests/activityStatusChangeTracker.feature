Feature: Activity Status Change Tracking

Scenario: Creating a new Activity
  Given The user creates an Activity
  Then an entry will be added to the Activity Status Change table with the following data

  | Activity ID        | Activity Status Changed To | Status Updated Date | Reason    |
  | Id of the Activity | Status ID                  | Date of change      | Free text |

Scenario: An Activity Status is changed
  Given a user changes activity id 2's activity status from  "Pending" to "On Hold" on 5/21/2018
  And enters the reason "Bill sick"
  Then an entry will be added to the Activity Status Change table with the following data

  | Activity ID        | Activity Status Changed To | Status Updated Date | Reason    |
  | 2                  | On Hold                    | 5/21/2018           | Bill Sick |

Scenario: Viewing an activity

 Given a user goes to view Activity id 2
 Then they should see a table with all the activity status changes for Activity 2 like:

  | Activity Status Changed To | Status Updated Date | Reason    |
  | Pending                    | 5/19/2018           |           |
  | On Hold                    | 5/21/2018           | Bill Sick |

Scenario: Admin Editing an Activity

  Given a user has admin permissions
  And that user goes to edit an Activity
  Then they will be able to add and delete rows from the 'Activity Status Change Table'
