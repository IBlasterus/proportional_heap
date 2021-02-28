/**
 * Proportional Heap it's a class that obtain association array with int digit values (nodes) and perform proportional
 * balance source value between nodes.
 *
 * @author Aleksandr Chernyi <iblasterus@gmail.com>
 * @date 02/28/2021
 *
 * @class
 * @constructor
 * @public
 */
class ProportionalHeap {
    /**
     * Source that will be proportional distribute between nodes
     *
     * @type {number}
     * @private
     */
    #source;

    /**
     * @type {Map}
     * @private
     */
    #nodes;

    /**
     * @type {null|string}
     */
    #error;

    constructor(source = 100, nodes = new Map()) {
        this.#error = null;

        this.#source = source;
        this.#checkSource();
        if (!!this.#error)
            return;

        this.#nodes = nodes;
        this.#checkNodes();
        if (!!this.#error)
            return;

        this.#processing();
    }

    get error() {
        return this.#error;
    }

    get source() {
        return this.#source;
    }

    set source(source) {
        this.#source = source;
        this.#checkSource();
        if (!!this.#error)
            return;
        this.#processing();
    }

    get nodes() {
        return this.#nodes;
    }

    set nodes(nodes) {
        this.#nodes = nodes;
        this.#checkNodes();
        if (!!this.#error)
            return;
        this.#processing();
    }

    #checkSource() {
        if (!this.#source) {
            this.#error = "Wrong source";
            return;
        }
        if (this.#source < 0) {
            this.#error = "Source less than 0";
            return;
        }
        this.#source = Math.round(this.#source);
        this.#error = null;
    }

    #checkNodes() {
        if (!this.#nodes || !this.#nodes instanceof Map) {
            this.#error = "Wrong nodes";
            return;
        }

        this.#nodes.forEach((value, key) => {
            if (!Number.isInteger(value)) {
                this.#error = `Node ${key} is not a number (${value})`;
                return;
            }
            if (value < 0) {
                this.#error = `Node ${key} less than 0 (${value})`;
                return;
            }
            this.#nodes.set(key, Math.round(value));
        });

        if (!!this.#error)
            return;

        this.#error = null;
    }

    /**
     * Proportional calculation each node in the way that their sum equal to source
     */
    #processing() {
        let result = new Map();
        this.#nodes.forEach((value, key) => {
            let sum = 1.0;
            this.#nodes.forEach((value_s, key_s) => {
                if (this.#nodes.get(key_s) !== this.#nodes.get(key))
                    sum += this.#nodes.get(key_s) / this.#nodes.get(key);
                result.set(key, Math.round(this.#source / sum));
            });
        });

        // Correcting rounding error
        while (this.#getArraySum(result) !== this.#source) {
            if (result.size > 0) {
                let max_key = this.#getMaxKey(result);
                if (this.#getArraySum(result) > this.#source) {
                    result.set(max_key, result.get(max_key) - 1);
                } else {
                    result.set(max_key, result.get(max_key) + 1);
                }
            } else
                break;
        }

        this.#nodes = result;
    }

    /**
     * Return sum values of Map
     *
     * @param {Map} a
     * @returns {number}
     */
    #getArraySum(a) {
        let total = 0;
        for (const value of a) {
            total += value[1];
        }
        return total;
    }

    /**
     * Return key of max value of Map
     *
     * @param {Map} a
     * @returns {undefined|number}
     */
    #getMaxKey(a) {
        let max_key;
        let max_value = 0;
        a.forEach((value, key) => {
            if (value >= max_value) {
                max_value = value;
                max_key = key;
            }
        });
        return max_key;
    }
}

// Test
let n = new Map();
n.set(1, 100);
n.set(2, 300);
n.set(3, 300);

let ph = new ProportionalHeap(100, n);

console.log(ph.error);
console.log(ph.source);
console.log(ph.nodes);