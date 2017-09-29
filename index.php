<?php

include "vendor/autoload.php";

use TencentTH\TSMSApi\Constants;

$TESTCASES = Constants::getTestcases();
$testcase_key = array_key_exists('t', $_REQUEST)
  ? $_REQUEST['t']
  : NULL;
$testcase = array_key_exists($testcase_key, $TESTCASES)
  ? $TESTCASES[$testcase_key]
  : NULL;

$source = $testcase !== NULL ? Constants::getTestcaseSource($testcase->func) : NULL;
$response = $testcase !== NULL ? $testcase->execute() : NULL;
?>
<html>
<head>
  <title>Tencent VOD API Test</title>
  <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.2/css/bootstrap.min.css">
  <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.2/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">
  <div class="row">
    <div class="col-sm-3">
      <h4>Test Cases</h4>
      <ul class="list-unstyled">
        <?php foreach ($TESTCASES as $k => $val): ?>
          <li>
            <a
              href="?t=<?php echo $k; ?>"
              style="padding-left:2px;border-left:solid 2px <?php echo $k === $testcase_key ? '#337ab7' : 'transparent'; ?>"
            >
              <?php echo $val->pass ? '✔' : '✘'; ?>
              <?php echo $val->title; ?>
            </a>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
    <div class="col-sm-9">
      <?php if ($testcase !== NULL): ?>
        <h1 style="margin-top:8px"><?php echo $testcase->title ?></h1>
        <div class="panel panel-default">
          <div class="panel-heading">
            <ul class="nav nav-pills">
              <li role="presentation" class="active"><a href="#results-results" data-toggle="tab">Results</a></li>
              <li role="presentation"><a href="#results-source" data-toggle="tab">Source</a></li>
            </ul>
          </div>
          <div class="panel-body">
            <div class="tab-content">
              <div role="tabpanel" class="tab-pane active" id="results-results">
                <?php if ($testcase->lastException): ?>
                  <h3 style="margin:0;">ERROR !</h3>
                  <?php var_dump($testcase->lastException); ?>
                <?php else: ?>
                  <pre style="margin:-16px;background-color:transparent;font-size:11px;white-space:pre-wrap"><?php print_r($response); ?></pre>
                <?php endif; ?>
              </div>
              <div role="tabpanel" class="tab-pane" id="results-source">
                <pre style="margin:-16px;background-color:transparent;font-size:11px;"><?php echo $source; ?></pre>
              </div>
            </div>
          </div>
        </div>

        <?php if ($testcase->note): ?>
          <div class="panel <?php echo $testcase->pass ? "panel-default" : "panel-danger"; ?>">
            <div class="panel-heading">
              Note
              <?php if (!$testcase->pass): ?>
                <span class="label label-danger">FAILED</span>
              <?php endif; ?>
            </div>
            <div class="panel-body"><?php echo nl2br(htmlspecialchars($testcase->note)); ?></div>
          </div>
        <?php endif; ?>
      <?php else: ?>
        <div class="alert alert-info" style="margin-top:16px;">Please select a test case from the menu</div>
      <?php endif; ?>
    </div>
  </div>
</body>
</html>
