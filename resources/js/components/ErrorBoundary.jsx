import { Component } from 'react';

/**
 * Top-level safety net — without this, an uncaught render error anywhere in
 * the tree unmounts everything and leaves a blank page with no clue why.
 * Shows the message + stack instead so it's debuggable from the browser
 * alone, no devtools console needed.
 */
export default class ErrorBoundary extends Component {
    constructor(props) {
        super(props);
        this.state = { error: null, info: null };
    }

    static getDerivedStateFromError(error) {
        return { error };
    }

    componentDidCatch(error, info) {
        this.setState({ info });
        console.error('Render error:', error, info);
    }

    render() {
        if (this.state.error) {
            return (
                <div style={{ fontFamily: 'monospace', padding: 32, maxWidth: 900, margin: '0 auto', color: '#2b2723' }}>
                    <h1 style={{ fontSize: 20, marginBottom: 12 }}>Something broke rendering this page</h1>
                    <pre style={{ whiteSpace: 'pre-wrap', background: '#fdf7ef', padding: 16, borderRadius: 8, border: '1px solid rgba(43,39,35,.16)' }}>
                        {String(this.state.error?.stack || this.state.error?.message || this.state.error)}
                    </pre>
                    {this.state.info?.componentStack && (
                        <pre style={{ whiteSpace: 'pre-wrap', marginTop: 12, fontSize: 12, opacity: 0.7 }}>
                            {this.state.info.componentStack}
                        </pre>
                    )}
                </div>
            );
        }

        return this.props.children;
    }
}
