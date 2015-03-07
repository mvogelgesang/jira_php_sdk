# jira_php_sdk
A simple PHP SDK utilizing Guzzle

## Prerequisites
- [Composer](https://getcomposer.org/)

## Installation
- Clone repo
- Run `composer install`

## Example Requests
### Instantiate Client
```php
$client = new jiraApiClient('username','password', 'http://myjirainstance.com');
```
### Get Issue
```php
$response = $client->getIssue('JT-123');
```
#### Response
```json
{
  "expand": "renderedFields,names,schema,transitions,operations,editmeta,changelog",
  "id": "32530",
  "self": "http://myjirainstance.com/rest/api/2/issue/32530",
  "key": "JT-123",
  "fields": {
    "progress": {
      "progress": 0,
      "total": 0
    },
    "summary": "This is a test Jira ticket",
    "issuetype": {
      "self": "http://myjirainstance.com/rest/api/2/issuetype/3",
      "id": "3",
      "description": "A task that needs to be done.",
      "iconUrl": "http://myjirainstance.com/images/icons/task.gif",
      "name": "Task",
      "subtask": false
    },
    "fixVersions": [],
    "resolution": null,
    "resolutiondate": null,
    "timespent": null,
    "reporter": {
      "self": "http://myjirainstance.com/rest/api/2/user?username=jdoe",
      "name": "jdoe",
      "emailAddress": "jdoe@myjirainstance.com",
      "avatarUrls": {
        "16x16": "http://myjirainstance.com/secure/useravatar?size=small&ownerId=jdoe&avatarId=11038",
        "48x48": "http://myjirainstance.com/secure/useravatar?ownerId=jdoe&avatarId=11038"
      },
      "displayName": "John Doe",
      "active": true
    },
    "aggregatetimeoriginalestimate": null,
    "updated": "2015-03-04T21:11:37.000-0500",
    "created": "2015-03-03T10:09:15.000-0500",
    "description": "As a user, I would like a JIRA API SDK to be written using Guzzle so that I can quickly and easily access the Jira API.",
    "priority": {
      "self": "http://myjirainstance.com/rest/api/2/priority/3",
      "iconUrl": "http://myjirainstance.com/images/icons/blank.png",
      "name": "Normal",
      "id": "3"
    },
    "duedate": null,
    "issuelinks": [
    ],
    "watches": {
      "self": "http://myjirainstance.com/rest/api/2/issue/JT-123/watchers",
      "watchCount": 2,
      "isWatching": false
    },
    "subtasks": [],
    "status": {
      "self": "http://myjirainstance.com/rest/api/2/status/1",
      "description": "The issue is open and ready for the assignee to start work on it.",
      "iconUrl": "http://myjirainstance.com/images/icons/status_open.gif",
      "name": "Open",
      "id": "1"
    },
    "labels": [
    ],
    "workratio": -1,
    "assignee": null,
    "attachment": [],
    "aggregatetimeestimate": null,
    "project": {
      "self": "http://myjirainstance.com/rest/api/2/project/JT",
      "id": "10273",
      "key": "JT",
      "name": "Jira Training",
      "avatarUrls": {
        "16x16": "http://myjirainstance.com/secure/projectavatar?size=small&pid=10273&avatarId=10593",
        "48x48": "http://myjirainstance.com/secure/projectavatar?pid=10273&avatarId=10593"
      }
    },
    "timeestimate": null,
    "aggregateprogress": {
      "progress": 0,
      "total": 0
    },
    "components": [],
    "comment": {
      "startAt": 0,
      "maxResults": 3,
      "total": 1,
      "comments": [
        {
          "self": "http://myjirainstance.com/rest/api/2/issue/32530/comment/48233",
          "id": "48233",
          "author": {
            "self": "http://myjirainstance.com/rest/api/2/user?username=jdoe",
            "name": "jdoe",
            "emailAddress": "jdoe@myjirainstance.com",
            "avatarUrls": {
              "16x16": "http://myjirainstance.com/secure/useravatar?size=small&ownerId=jdoe&avatarId=11038",
              "48x48": "http://myjirainstance.com/secure/useravatar?ownerId=jdoe&avatarId=11038"
            },
            "displayName": "John Doe",
            "active": true
          },
          "body": "The requirements need some updates before I can start work.",
          "updateAuthor": {
            "self": "http://myjirainstance.com/rest/api/2/user?username=jdoe",
            "name": "jdoe",
            "emailAddress": "jdoe@myjirainstance.com",
            "avatarUrls": {
              "16x16": "http://myjirainstance.com/secure/useravatar?size=small&ownerId=jdoe&avatarId=11038",
              "48x48": "http://myjirainstance.com/secure/useravatar?ownerId=jdoe&avatarId=11038"
            },
            "displayName": "John Doe",
            "active": true
          },
          "created": "2015-03-03T10:10:50.000-0500",
          "updated": "2015-03-03T10:10:50.000-0500"
        }
      ]
    },
    "timeoriginalestimate": null,
    "aggregatetimespent": null
  }
}
```
### Create Issue
```php
$fields = array( 
  'fields' => array(
    'project' => array(
      'id' => 10200
    ),
    'summary' => 'Ticket title',
    'issuetype' => array(
      'name' => 'Task'
    ),
    'reporter' => array(
      'name' => 'myusername'
    ),
    'labels' => array(),
    'description' => 'This is a description of the ticket',
	)
); 

$newIssue = $client->createIssue($fields);
```
#### Response
```json
{
  "id": "32596",
  "key": "JT-124",
  "self": "http://myjirainstance.com/rest/api/2/issue/32596"
}
```