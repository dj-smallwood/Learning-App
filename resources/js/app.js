import './bootstrap';
import Alpine from 'alpinejs';
import flashcard from './components/flashcard';

Alpine.data('flashcard', flashcard);
window.Alpine = Alpine;
Alpine.start();
