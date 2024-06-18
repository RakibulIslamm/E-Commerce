export function toggleVisibility(showId, hideId, property) {
    const showElement = document.getElementById(showId);
    const hideElement = document.getElementById(hideId);

    showElement.classList.remove("hidden");
    showElement.classList.add(property);

    hideElement.classList.remove(property);
    hideElement.classList.add("hidden");
}

export function element(id) {
    return document.getElementById(id);
}

export const sessionMessageClose = () => {
    const session = document.getElementById("session_status");
    document.getElementById("icon").addEventListener("click", () => {
        session.classList.add("hidden");
        session.classList.remove("flex");
    });
};
