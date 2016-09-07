<?php
/**
 * @转载代码
 */
class Multi
{
    protected $curl_multi_handle;
    protected $curl_handle_pools = [];
    protected $curl_timeout = 2;
    protected $waiting_ms = 10000;
    protected $select_timeout = 1;
    protected $response;

    public function addUrl($url, array $opts = [])
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, $this->curl_timeout);
        curl_setopt_array($ch, $opts);
        $this->curl_handle_pools[] = $ch;
        return $this;
    }

    /**
     * 并行请求
     */
    public function run()
    {
        $this->curl_multi_handle = curl_multi_init();
        foreach ($this->curl_handle_pools as $curl_handle) {
            curl_multi_add_handle($this->curl_multi_handle, $curl_handle);
        }
        $active = null;
        do {
            $mrc = curl_multi_exec($this->curl_multi_handle, $active);
        } while ($mrc == CURLM_CALL_MULTI_PERFORM);

        while ($active && $mrc == CURLM_OK) {
            if (curl_multi_select($this->curl_multi_handle, $this->select_timeout) == -1) {
                usleep($this->waiting_ms);
            }
            do {
                $mrc = curl_multi_exec($this->curl_multi_handle, $active);
                while ($info = curl_multi_info_read($this->curl_multi_handle)) {
                    $this->response[$this->getKey($info['handle'])] = [
                        'info'   => curl_getinfo($info['handle']),
                        'result' => curl_multi_getcontent($info['handle'])
                    ];
                }
            } while ($mrc == CURLM_CALL_MULTI_PERFORM);
        }
        foreach ($this->curl_handle_pools as $curl_handle) {
            curl_multi_remove_handle($this->curl_multi_handle, $curl_handle);
            curl_close($curl_handle);
        }
        curl_multi_close($this->curl_multi_handle);
        return $this;
    }

    public function getResult()
    {
        return $this->response;
    }

    private function getKey($value)
    {
        return array_search($value, $this->curl_handle_pools);
    }
}

$action = isset($_GET['action']) ? $_GET['action'] : null;

function index()
{
    usleep(5000);
    echo 1;
}

function index2()
{
    echo 2;
}

if (null !== $action) {
    $action();
    die;
}




$multi = new Multi();
$mrcs = $multi->addUrl('http://develop/test/Multi.php?action=index')
              ->addUrl('http://develop/test/Multi.php?action=index2')
              ->addUrl('m')
              ->run();
print_r($mrcs->getResult());
