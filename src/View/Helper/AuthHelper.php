 <?php
/**
 * AuthHelper: Allow access to auth vars in view
 * @usage $this->Auth->get('Admin.id'), $this->Auth->get('User.email')
 */
namespace App\View\Helper;

use Cake\View\Helper;
use Cake\Controller\Component;
class AuthHelper extends Helper
{
    /**
     * The current user, used for stateless authentication when
     * sessions are not available.
     *
     * @var array
     */
    protected $_user = null;
    /**
     * Initialize current user from session data
     * before rendering view.
     * 
     * @return void
     */
    public function beforeRender()
    {
        $this->_user = $this->request->Session()->read('Auth');
    }
    /**
     * Get the current user.
     * 
     * @param  string $key field to retrieve. Leave null to get entire User record
     * @return array|null Either User record or null if no user is logged in.
     */
    public function get($key = null)
    {
        if( empty($key) ) {
            return $this->_user;
        }
        if( strpos($key, '.') !== false ) {
            list($sessionKey, $field) = explode('.', $key);
            return isset($this->_user[$sessionKey][$field]) ? $this->_user[$sessionKey][$field] : null;
        }
        return null;
    }

}