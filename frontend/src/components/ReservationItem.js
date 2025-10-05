import React from 'react';
import { Card, Button, Badge } from 'react-bootstrap';

const ReservationItem = ({ booking, onDelete }) => {
    return (
        <Card className="h-100">
            <Card.Body>
                <Card.Title className="d-flex justify-content-between align-items-center">
                    {booking.name} {booking.surname}
                </Card.Title>

                <Card.Text>
                    <div className="mb-2">
                        <strong>Email:</strong><br />
                        <small>{booking.email}</small>
                    </div>

                    <div className="mb-2">
                        <strong>Phone:</strong><br />
                        <small>{booking.phone}</small>
                    </div>

                    <div className="mb-2">
                        <strong>Start date:</strong><br />
                        <Badge bg="secondary">{booking.startDate}</Badge>
                    </div>

                    <div className="mb-2">
                        <strong>End date:</strong><br />
                        <Badge bg="secondary">{booking.endDate}</Badge>
                    </div>

                    <div className="mb-2">
                        <strong>Total price:</strong><br />
                        <Badge bg="secondary">{booking.price}</Badge>
                    </div>
                </Card.Text>

                <Button
                    variant="danger"
                    size="sm"
                    onClick={() => onDelete(booking.id)}
                    className="w-100"
                >
                    Cancel reservation
                </Button>
            </Card.Body>
        </Card>
    );
};

export default ReservationItem;
