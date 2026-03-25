import './bootstrap';

document.addEventListener('DOMContentLoaded', () => {
	const input = document.getElementById('join-search');
	const cards = Array.from(document.querySelectorAll('.join-card'));

	if (input) {
		input.addEventListener('input', (event) => {
			const term = event.target.value.trim().toLowerCase();

			cards.forEach((card) => {
				const haystack = card.dataset.search || '';
				const matches = haystack.includes(term);
				card.classList.toggle('hidden', !matches);
			});
		});
	}

	cards.forEach((card, index) => {
		card.animate(
			[
				{ opacity: 0, transform: 'translateY(10px)' },
				{ opacity: 1, transform: 'translateY(0)' },
			],
			{
				duration: 320,
				delay: 50 * index,
				fill: 'both',
				easing: 'ease-out',
			},
		);
	});
});
