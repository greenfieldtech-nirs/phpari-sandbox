<?php

    require_once "c:/xampp/htdocs/phpari-sandbox/www/vendor/autoload.php";

    class BasicStasisApplication
    {

        private $ariEndpoint;
        private $stasisClient;
        private $stasisLoop;
        private $phpariObject;
        private $stasisChannelID;
        private $dtmfSequence = "";

        public $stasisLogger;

        public function __construct($appname = "hello-world")
        {
            try {
                if (is_null($appname))
                    throw new Exception("[" . __FILE__ . ":" . __LINE__ . "] Stasis application name must be defined!", 500);

                $this->phpariObject = new phpari($appname);

                $this->ariEndpoint  = $this->phpariObject->ariEndpoint;
                $this->stasisClient = $this->phpariObject->stasisClient;
                $this->stasisLoop   = $this->phpariObject->stasisLoop;
                $this->stasisLogger = $this->phpariObject->stasisLogger;
                $this->stasisEvents = $this->phpariObject->stasisEvents;
            } catch (Exception $e) {
                echo $e->getMessage();
                exit(99);
            }
        }

        public function setDtmf($digit = NULL)
        {
            try {

                $this->dtmfSequence .= $digit;

                return TRUE;

            } catch (Exception $e) {
                return FALSE;
            }
        }

        // process stasis events
        public function StasisAppEventHandler()
        {




/** EVENT: StasisEnd **/

$this->stasisEvents->on("StasisEnd", function ($event) {
                $this->stasisLogger->notice("Event received: StasisEnd");
                $this->phpariObject->channels()->channel_delete($this->stasisChannelID);
});


/** EVENT: StasisStart **/

$this->stasisEvents->on("StasisStart", function ($event) {
                $this->stasisLogger->notice("Event received: StasisStart");
                $this->stasisChannelID = $event->channel->id;
                $this->phpariObject->channels()->channel_answer($this->stasisChannelID);

// $this->phpariObject->channels()->channel_playback($this->stasisChannelID, 'sound:demo-congrats', NULL, NULL, NULL, 'play1');

                $this->phpariObject->channels()->channel_playback($this->stasisChannelID, 'sound:demo-thanks', NULL, NULL, NULL, 'play1');
});

        }

        public function StasisAppConnectionHandlers()
        {
            try {
                $this->stasisClient->on("request", function ($headers) {
                    $this->stasisLogger->notice("Request received!");
                });

                $this->stasisClient->on("handshake", function () {
                    $this->stasisLogger->notice("Handshake received!");
                });

                $this->stasisClient->on("message", function ($message) {
                    $event = json_decode($message->getData());
                    $this->stasisLogger->notice('Received event: ' . $event->type);
                    $this->stasisEvents->emit($event->type, array($event));
                });

            } catch (Exception $e) {
                echo $e->getMessage();
                exit(99);
            }
        }

        public function execute()
        {
            try {
                $this->stasisClient->open();
                $this->stasisLoop->run();
            } catch (Exception $e) {
                echo $e->getMessage();
                exit(99);
            }
        }

    }

    $basicAriClient = new BasicStasisApplication("hello-world");

    $basicAriClient->stasisLogger->info("Starting Stasis Program... Waiting for handshake...");
    $basicAriClient->StasisAppEventHandler();

    $basicAriClient->stasisLogger->info("Initializing Handlers... Waiting for handshake...");
    $basicAriClient->StasisAppConnectionHandlers();

    $basicAriClient->stasisLogger->info("Connecting... Waiting for handshake...");
    $basicAriClient->execute();

    exit(0);
