import { toast } from 'vue3-toastify';

/**
 * Classe para toasts do sistema
 */
class Notify {
    /**
     * Toast de sucesso
     * @param {String} message
     */
    success = (message = 'sucesso') => {
        toast(message, {
            type: 'success',
            theme: 'colored'
        }); // 
    }
    
    /**
     * Toast de erro
     * @param {String} message
     */
    error = (message = 'erro') => {
        toast(message, {
            type: 'error',
            theme: 'colored'
        }); // 
    }

}
const notify = new Notify();

export default notify;