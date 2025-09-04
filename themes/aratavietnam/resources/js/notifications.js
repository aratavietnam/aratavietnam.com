/**
 * Notification System for Arata Vietnam
 * Handles success, error, warning, and info notifications
 */

class NotificationManager {
    constructor() {
        this.container = null;
        this.notifications = [];
        this.init();
    }

    init() {
        // Create notification container if it doesn't exist
        this.createContainer();
    }

    createContainer() {
        if (document.querySelector('#notification-container')) return;

        this.container = document.createElement('div');
        this.container.id = 'notification-container';
        this.container.className = 'fixed top-4 right-4 z-[9999] space-y-3 max-w-sm';
        document.body.appendChild(this.container);
    }

    show(message, type = 'info', duration = 5000, options = {}) {
        const notification = this.createNotification(message, type, options);
        this.container.appendChild(notification);
        
        // Animate in
        requestAnimationFrame(() => {
            notification.classList.remove('translate-x-full', 'opacity-0');
        });

        // Auto remove after duration
        if (duration > 0) {
            setTimeout(() => {
                this.remove(notification);
            }, duration);
        }

        return notification;
    }

    createNotification(message, type, options = {}) {
        const notification = document.createElement('div');
        notification.className = `
            transform translate-x-full opacity-0 transition-all duration-300 ease-in-out
            bg-white border border-gray-200 rounded-lg shadow-lg p-4 
            flex items-start space-x-3 max-w-sm
        `;

        const { icon, bgColor, textColor, borderColor } = this.getTypeStyles(type);

        notification.innerHTML = `
            <div class="flex-shrink-0">
                <div class="w-5 h-5 ${bgColor} ${textColor} rounded-full flex items-center justify-center">
                    ${icon}
                </div>
            </div>
            <div class="flex-1 min-w-0">
                <div class="text-sm font-medium text-gray-900">
                    ${message}
                </div>
                ${options.description ? `
                    <div class="text-xs text-gray-500 mt-1">
                        ${options.description}
                    </div>
                ` : ''}
                ${options.actions ? this.createActions(options.actions) : ''}
            </div>
            <button class="flex-shrink-0 ml-2 text-gray-400 hover:text-gray-600 transition-colors" onclick="window.notificationManager.remove(this.closest('.transform'))">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        `;

        // Add border color
        notification.style.borderLeftColor = borderColor;
        notification.style.borderLeftWidth = '4px';

        return notification;
    }

    getTypeStyles(type) {
        const styles = {
            success: {
                icon: '<svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>',
                bgColor: 'bg-green-100',
                textColor: 'text-green-600',
                borderColor: '#10b981'
            },
            error: {
                icon: '<svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>',
                bgColor: 'bg-red-100',
                textColor: 'text-red-600',
                borderColor: '#ef4444'
            },
            warning: {
                icon: '<svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>',
                bgColor: 'bg-yellow-100',
                textColor: 'text-yellow-600',
                borderColor: '#f59e0b'
            },
            info: {
                icon: '<svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>',
                bgColor: 'bg-blue-100',
                textColor: 'text-blue-600',
                borderColor: '#3b82f6'
            }
        };
        
        return styles[type] || styles.info;
    }

    createActions(actions) {
        return `
            <div class="mt-2 flex space-x-2">
                ${actions.map(action => `
                    <button 
                        class="text-xs bg-gray-100 hover:bg-gray-200 text-gray-700 px-2 py-1 rounded transition-colors"
                        onclick="${action.onclick}"
                    >
                        ${action.text}
                    </button>
                `).join('')}
            </div>
        `;
    }

    remove(notification) {
        if (!notification || !notification.parentNode) return;

        notification.classList.add('translate-x-full', 'opacity-0');
        
        setTimeout(() => {
            if (notification.parentNode) {
                notification.parentNode.removeChild(notification);
            }
        }, 300);
    }

    // Convenience methods
    success(message, options = {}) {
        return this.show(message, 'success', 5000, options);
    }

    error(message, options = {}) {
        return this.show(message, 'error', 8000, options);
    }

    warning(message, options = {}) {
        return this.show(message, 'warning', 6000, options);
    }

    info(message, options = {}) {
        return this.show(message, 'info', 5000, options);
    }

    // Clear all notifications
    clear() {
        const notifications = this.container.querySelectorAll('.transform');
        notifications.forEach(notification => this.remove(notification));
    }
}

// Initialize global notification manager
window.notificationManager = new NotificationManager();

// Export for modules
export default NotificationManager;
