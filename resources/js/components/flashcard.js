export default () => ({
    flashcards: [],
    currentCard: 0,
    isFlipped: false,
    userPoints: 0,
    completedCards: new Set(),
    totalCards: 0,

    init() {
        this.flashcards = this.$el.dataset.flashcards ? JSON.parse(this.$el.dataset.flashcards) : [];
        this.userPoints = parseInt(this.$el.dataset.points || 0);
        this.totalCards = this.flashcards.length;
        this.completedCards = new Set(JSON.parse(this.$el.dataset.completed || '[]'));
    },

    nextCard() {
        if (this.currentCard < this.flashcards.length - 1) {
            this.currentCard++;
            this.isFlipped = false;
        }
    },

    previousCard() {
        if (this.currentCard > 0) {
            this.currentCard--;
            this.isFlipped = false;
        }
    },

    flipCard() {
        this.isFlipped = !this.isFlipped;
    },

    async markComplete() {
        if (this.completedCards.has(this.flashcards[this.currentCard].id)) {
            return;
        }

        try {
            const response = await fetch(`/flashcards/${this.flashcards[this.currentCard].id}/complete`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            });

            const data = await response.json();
            
            if (data.success) {
                this.completedCards.add(this.flashcards[this.currentCard].id);
                this.userPoints = data.new_points;
                
                if (data.level_up) {
                    window.dispatchEvent(new CustomEvent('level-up', { 
                        detail: {
                            level: data.level_up.level,
                            color: data.level_up.color
                        }
                    }));
                }
                
                alert(data.message);
            }
        } catch (error) {
            console.error('Error:', error);
        }
    },

    isCurrentCardCompleted() {
        return this.completedCards.has(this.flashcards[this.currentCard].id);
    }
}); 