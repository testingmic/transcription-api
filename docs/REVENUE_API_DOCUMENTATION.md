# Revenue API Endpoint Documentation

## Overview
The Revenue API endpoint provides comprehensive analytics data for payment transactions, including revenue breakdowns, growth metrics, and recent transaction history.

## Endpoint Details

### URL
```
GET /api/payments/revenue
```

### Authentication
- **Required**: Yes
- **Roles**: Admin, Moderator only

### Query Parameters

| Parameter | Type | Required | Format | Description |
|-----------|------|----------|--------|-------------|
| `start_date` | string | No | YYYY-MM-DD | Filter transactions from this date onwards |
| `end_date` | string | No | YYYY-MM-DD | Filter transactions up to this date |

### Example Requests

#### Basic Request (All Data)
```bash
curl -X GET "https://your-domain.com/api/payments/revenue" \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -H "Content-Type: application/json"
```

#### Filtered by Date Range
```bash
curl -X GET "https://your-domain.com/api/payments/revenue?start_date=2025-01-01&end_date=2025-03-31" \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -H "Content-Type: application/json"
```

## Response Format

### Success Response (200 OK)

```json
{
  "status": "success",
  "data": {
    "totalRevenue": 125000.50,
    "totalTransactions": 342,
    "averageTransactionValue": 365.50,
    "revenueByPlan": [
      {
        "plan": "PRO",
        "revenue": 85000.00,
        "transactions": 250,
        "percentage": 68.0
      },
      {
        "plan": "PREMIUM",
        "revenue": 40000.50,
        "transactions": 92,
        "percentage": 32.0
      }
    ],
    "revenueByPeriod": [
      {
        "period": "2025-01",
        "revenue": 45000.00,
        "transactions": 120
      },
      {
        "period": "2025-02",
        "revenue": 52000.00,
        "transactions": 145
      }
    ],
    "revenueByMonth": [
      {
        "month": "January 2025",
        "revenue": 45000.00,
        "transactions": 120
      },
      {
        "month": "February 2025",
        "revenue": 52000.00,
        "transactions": 145
      }
    ],
    "revenueByDay": [
      {
        "date": "2025-01-15",
        "revenue": 2500.00,
        "transactions": 8
      },
      {
        "date": "2025-01-16",
        "revenue": 3200.50,
        "transactions": 10
      }
    ],
    "topPlans": [
      {
        "plan": "PRO",
        "revenue": 85000.00,
        "transactions": 250
      },
      {
        "plan": "PREMIUM",
        "revenue": 40000.50,
        "transactions": 92
      }
    ],
    "growthRate": {
      "currentPeriod": 28000.50,
      "previousPeriod": 52000.00,
      "percentageChange": -46.15
    },
    "recentTransactions": [
      {
        "id": 1001,
        "user_id": 45,
        "user_name": "John Doe",
        "user_email": "john.doe@example.com",
        "plan": "PRO",
        "amount": 6.00,
        "amount_ghs": 45.00,
        "status": "success",
        "created_at": "2025-01-21 14:30:00"
      }
    ]
  },
  "requestId": "rev_abc123xyz",
  "cused": false
}
```

## Response Fields

### Summary Statistics
- **totalRevenue** (float): Total revenue in GHS (Ghana Cedis)
- **totalTransactions** (int): Total number of successful transactions
- **averageTransactionValue** (float): Average transaction value in GHS

### Revenue Breakdowns

#### revenueByPlan
Array of objects showing revenue breakdown by subscription plan:
- **plan** (string): Plan name (FREE, PRO, PREMIUM)
- **revenue** (float): Total revenue for this plan
- **transactions** (int): Number of transactions
- **percentage** (float): Percentage of total revenue (0-100)

#### revenueByPeriod
Array of objects showing revenue by month (YYYY-MM format):
- **period** (string): Period identifier (e.g., "2025-01")
- **revenue** (float): Revenue for this period
- **transactions** (int): Number of transactions

#### revenueByMonth
Array of objects showing revenue by month (human-readable):
- **month** (string): Month name (e.g., "January 2025")
- **revenue** (float): Revenue for this month
- **transactions** (int): Number of transactions

#### revenueByDay
Array of objects showing daily revenue (last 30 days):
- **date** (string): Date in YYYY-MM-DD format
- **revenue** (float): Revenue for this day
- **transactions** (int): Number of transactions

#### topPlans
Array of top performing plans sorted by revenue (descending)

#### growthRate
Object showing period-over-period growth:
- **currentPeriod** (float): Current month revenue
- **previousPeriod** (float): Previous month revenue
- **percentageChange** (float): Percentage change (can be negative)

#### recentTransactions
Array of most recent transactions (limit: 10):
- **id** (int): Transaction ID
- **user_id** (int): User ID
- **user_name** (string): User's full name
- **user_email** (string): User's email
- **plan** (string): Subscription plan
- **amount** (float): Amount in USD
- **amount_ghs** (float): Amount in GHS
- **status** (string): Transaction status (lowercase)
- **created_at** (string): Timestamp

## Status Codes

| Code | Description |
|------|-------------|
| 200 | Success - Data retrieved successfully |
| 401 | Unauthorized - Invalid or missing authentication token |
| 403 | Forbidden - User doesn't have required role (Admin/Moderator) |
| 400 | Bad Request - Invalid date format in query parameters |
| 500 | Internal Server Error - Database or server error |

## Notes

1. **Currency**: All revenue amounts are in GHS (Ghana Cedis)
2. **Successful Payments Only**: Only includes payments with status: 'Success', 'Successful', 'Approved', or 'completed'
3. **Date Formats**: 
   - Query parameters: YYYY-MM-DD
   - Response timestamps: YYYY-MM-DD HH:MM:SS
   - Period format: YYYY-MM
4. **Sorting**:
   - Plans sorted by revenue (descending)
   - Time-based data sorted chronologically
   - Recent transactions sorted by date (descending)
5. **Empty Data**: Returns empty arrays `[]` if no data exists
6. **Growth Rate**: Compares current month vs previous month
7. **Recent Transactions**: Limited to 10 most recent transactions

## Implementation Details

### Database Tables Used
- `payments` - Main payments table
- `users` - User information (joined for recent transactions)

### Filters Applied
- Only successful payment statuses are included
- Optional date range filtering via query parameters
- Admin/Moderator role restriction

### Performance Considerations
- Uses optimized SQL queries with proper indexing
- Limits recent transactions to 10 records
- Limits daily data to 30 days
- Uses COALESCE for null handling

## Error Handling

All errors return a standard error response:

```json
{
  "status": "error",
  "message": "Error description here"
}
```

## Testing

You can test the endpoint using the provided curl commands or any API testing tool like Postman or Insomnia.

### Test Checklist
- [ ] Test without authentication (should return 401)
- [ ] Test with User role (should return 403)
- [ ] Test with Admin role (should return 200)
- [ ] Test with date filters
- [ ] Test with invalid date format (should return 400)
- [ ] Verify all data fields are present
- [ ] Verify calculations (percentages, averages, growth rate)

