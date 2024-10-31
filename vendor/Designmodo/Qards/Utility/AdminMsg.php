<?php
/*
 * This file is part of the Designmodo WordPress Plugin.
 *
 * (c) Designmodo Inc. <info@designmodo.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Designmodo\Qards\Utility;

/**
 * AdminMsg provides features of admin messages.
 */
class AdminMsg
{
    static $msgs = array();

    /**
     * Add message
     *
     * @param string $msg
     * @param bool $status
     */
    static public function add($msg, $status = true)
    {
        self::$msgs[] = array(
            'status' => $status,
            'msg' => $msg
        );
    }

    static public function show()
    {
        add_action(
            'admin_notices',
            function () {
                foreach (AdminMsg::$msgs as $msg) {
                    ?>
                    <div class="<?php echo $msg['status'] ? 'updated' : 'error'; ?>">
                        <p><?php echo $msg['msg']; ?></p>
                    </div>
                    <?php
                }
            }
        );
    }
}