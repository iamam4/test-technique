export interface ApiMessage {
    error?: string;
    message?: string;
    violations?: Array<{
        propertyPath: string;
        title: string;
    }>;
}