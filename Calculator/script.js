function appendToDisplay(value) {
    document.getElementById('display').value += value;
}

function clearDisplay() {
    document.getElementById('display').value = '';
}

function calculateResult() {
    let expression = document.getElementById('display').value;
    // Preventing the user from accidentally causing a syntax error
    if (expression.includes('Math.sin') || expression.includes('Math.cos') ||
        expression.includes('Math.tan') || expression.includes('Math.sqrt') ||
        expression.includes('Math.log') || expression.includes('Math.exp')) {
        try {
            expression = expression.replace(/Math.sin\(/g, 'Math.sin(')
                                    .replace(/Math.cos\(/g, 'Math.cos(')
                                    .replace(/Math.tan\(/g, 'Math.tan(')
                                    .replace(/Math.sqrt\(/g, 'Math.sqrt(')
                                    .replace(/Math.log\(/g, 'Math.log(')
                                    .replace(/Math.exp\(/g, 'Math.exp(')
                                    .replace(/Math.PI/g, Math.PI);
        } catch (e) {
            alert('Invalid Expression');
            return;
        }
    }
    try {
        const result = eval(expression);
        document.getElementById('display').value = result;
    } catch (e) {
        alert('Invalid Expression');
    }
}
