<?php

/**
 * @file
 * Contains the client class for communicating with Jira issue tracking api.
 */

require 'vendor/autoload.php';
use GuzzleHttp\Client;
use GuzzleHttp\Stream\Stream;

class jiraApiClient extends Client {

  protected $username = NULL;
  protected $password = NULL;
  protected $apiUrl = NULL;

  /**
   * Constructor.
   *
   * @param string $username
   *   A Jira username.
   *
   * @param string $password
   *   Jira password
   *
   * @param string $apiUrl
   *   Base url of Jira instance. (eg http://myjirasite.com)
   *
   * @return jiraApiClient
   */
  public function __construct($username, $password, $apiUrl) {
    parent::__construct(['base_url' => $apiUrl . '/rest/api/2/']);
    $this->username = $username;
    $this->password = $password;
    $this->apiUrl = $apiUrl;
    $this->setDefaultOption('auth', array($username, $password, 'Basic'));
    $this->setDefaultOption('headers', array(
      'Content-Type' => 'application/json',
      'Accept' => '*'
    ));
  }

  /**
   * Requests a specific issue
   *
   * @param string issueKey
   *   The unique issue identifier (eg JIRA-123)
   *
   * @return array
   *   The response, including results.
   */
  public function getIssue($issueKey) {
    $request = $this->createRequest('GET','issue/' . $issueKey);
    $response = $this->send($request);
    $data = $response->json();

    return $data;
  }

  /**
   * Creates an Issue
   *
   * @param array $fields
   *  An associative array containing fields to populate new ticket.
   *
   * @return array
   *  The response, including results
   */
  public function createIssue($fields = array()) {


    $request = $this->createRequest('POST','issue');
    $request->setBody(Stream::factory(json_encode($fields)));

    $response = $this->send($request);
    $data = $response->json();

    return $data;
  }

  /**
   * Creates multiple issues
   *
   * @param array $issues
   *  An array containing issues to be created.
   *
   * @return array
   *  The response, including results
   */
  public function createIssuesBulk($issues = array()) {
    $request = $this->createRequest('POST','issue/bulk');
    $request->setBody(Stream::factory(json_encode($issues)));

    $response = $this->send($request);
    $data = $response->json();

    return $data;
  }

  /**
   * Requests an Issue object for a specific project issue type.
   *
   * @param string $projectIds
   *   A comma separated list of project Ids
   *
   * @param string $projectKeys
   *   A comma separated list of project keys
   *
   * @param array $issueTypeIds
   *   An array of issuetypeIds
   *
   * @param array $issueTypeNames
   *   An array of issuetypeNames
   *
   * @return array
   *  The response, including results
   */
  public function createMeta($projectIds=NULL, $projectKeys=NULL, $issueTypeIds=NULL, $issuetypeNames=NULL) {
    $queryString = 'projectIds=' . $projectIds . '&projectKeys=' . $projectKeys . '&issuetypeIds=' . $issuetypeIds . '&issuetypeNames=' . $issuetypeNames;
    $queryString .= '&expand=projects.issuetypes.fields';
    
    $request = $this->createRequest('GET','issue/createmeta?' . $queryString);
    $response = $this->send($request);
    $data = $response->json();

    return $data;
  }

  /**
   * Gets a Project
   *
   * @param string $projectKey
   *  The project ID or Key
   *
   * @return array
   *  The response, including results
   */
  public function getProject($projectKey) {
    $request = $this->createRequest('GET','project/' . $projectKey);

    $response = $this->send($request);
    $data = $response->json();

    return $data;
  }

  /**
   * Creates an Issue
   *
   * @param string $jql
   *  The Jira query
   *
   * @param number $offset
   *  The index of the first issue to return
   *
   * @param number $limit
   *  The maximum number of issues to return (default to 50)
   *
   * @param boolean $validateQuery
   *  whether to validate the JQL query (default to true)
   *
   * @param string $field
   *  The list of fields to return for each issue.
   *
   * @param string $expand
   *  A comma-separated list of the parameters to expand.
   *
   * @return array
   *  The response, including results
   */
  public function search($jql, $offset=0, $limit=50, $validateQuery=true, $fields="", $expand="") {
    $fields = array(
      "jql" => $jql,
      "startAt" => $offset,
      "maxResults" => $limit,
      "fields" => array($fields),
      "expand" => array($expand),
    );

    $request = $this->createRequest('POST','search');
    $request->setBody(Stream::factory(json_encode($fields)));

    $response = $this->send($request);
    $data = $response->json();

    return $data;
  }

}

