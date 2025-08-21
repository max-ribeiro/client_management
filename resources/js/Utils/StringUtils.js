/**
 * Returns first letters of name and surname,
 * or just the first letter of the name
 * 
 * @param {String} fullName 
 * @returns String
 */
export function getInitials(fullName) {
    if (!fullName) return "";

    const parts = fullName.trim().split(/\s+/);

    let initials = parts[0][0].toUpperCase();

    if (parts.length > 1) {
        initials += parts[parts.length - 1][0].toUpperCase();
    }

    return initials;
}
