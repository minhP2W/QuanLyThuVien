const scrollPosition = sessionStorage.getItem('scrollPosition');

if (scrollPosition !== null) {
    window.scrollTo(0, parseInt(scrollPosition));
    sessionStorage.removeItem('scrollPosition');
}