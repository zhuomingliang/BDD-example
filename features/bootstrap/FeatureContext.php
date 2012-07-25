<?php

use Behat\Behat\Context\ClosuredContextInterface,
    Behat\Behat\Context\TranslatedContextInterface,
    Behat\Behat\Context\BehatContext,
    Behat\Behat\Exception\PendingException;

use Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode;
use Behat\Mink\Exception\ExpectationException;
use Behat\MinkExtension\Context\MinkContext;

//
// Require 3rd-party libraries here:
//
//   require_once 'PHPUnit/Autoload.php';
//   require_once 'PHPUnit/Framework/Assert/Functions.php';
//

/**
 * Features context.
 */
class FeatureContext extends MinkContext
{
    /**
     * Initializes context.
     * Every scenario gets it's own context object.
     *
     * @param array $parameters context parameters (set them up through behat.yml)
     */
    public function __construct(array $parameters)
    {
        // Initialize your context here
    }


    /**
     * @Then /^我等待了“(?P<number>[^"]*)”毫秒$/
     */
    public function iWaitFor($number)
    {
        $this->getSession()->wait($number);
        // $this->getSession()->getDriver()->wdSession->timeouts()->implicit_wait($number);
    }

    /**
     * @Then /^我应该看到了包含“(?P<text>[^"]*)”内容的对话框$/
     */
    public function iShouldSeeAlertContains($text)
    {
        $actual = $this->getSession()->getDriver()->wdSession->alert_text();
        if (!preg_match("/$text/", $actual)) {
            $message = sprintf('Current page "%s" does not match the regex "%s".', $actual, $text);
            throw new ExpectationException($message, $this->getSession());
        }
    }

    /**
     * @When /^我点击了对话框的“确定”按钮$/
     */
    public function iClickAlertAccept()
    {
        $actual = $this->getSession()->getDriver()->wdSession->accept_alert();
    }

    /**
     * @When /^我点击了对话框的“取消”按钮$/
     */
    public function iClickAlertDismiss()
    {
        $actual = $this->getSession()->getDriver()->wdSession->dismiss_alert();
    }
}
