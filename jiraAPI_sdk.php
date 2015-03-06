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
   * @param string $project
   *  The Jira key for a project, usually two to three letters
   *
   * @param string $summary
   *  A one sentence summary of the issue
   * 
   * @param string $issuetype
   *  Type of task to create
   *
   * @param array $labels
   *  An array containing labels for the ticket. Eg array("maintenance","sql")
   * 
   * @param string $description
   *  Description of the work to be done and any links
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


  public function getProject($projectKey) {
    $request = $this->createRequest('GET','project' . $projectKey);

    $response = $this->send($request);
    $data = $response->json();

    return $data;
  }
 
}

createIssue takes in key value pairs
convert project name into ids


